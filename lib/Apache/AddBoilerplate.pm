package Apache::AddBoilerplate;
# $Id: AddBoilerplate.pm,v 1.17 2010/04/29 14:58:58 todd Exp $

use strict;

use Apache2::compat;
use Apache::Constants qw(:common);
use Apache::File;

use Apache2::Const -compile => qw(DIR_MAGIC_TYPE OK DECLINED);
use Apache2::SubRequest;
use Boilerplate;

sub handler {
    my $r = shift;


    # A directory request has content-type = httpd/unix-directory
    # we check that the uri ends in a slash, since only in that case
    # do we want to redirect, and finally to avoid redirect loops
    # we only do this on the initial request.
    # You must load Apache2::SubRequest in order to run internal_redirect
    if ($r->content_type eq 'httpd/unix-directory' 
        && $r->uri =~ '/$'
	&& $r->is_initial_req
	&& ($r->unparsed_uri eq $r->uri)
	) {
	$r->internal_redirect($r->uri . 'index.html');
	return OK;
    }    
   
    return DECLINED unless $r->content_type eq 'text/html';
    -r $r->filename || return DECLINED;

    my $rc = $r->meets_conditions;
    return $rc unless $rc == OK;

    my $fh = Apache::File->new($r->filename) || return DECLINED;

#    my $stats;
#    if ($r->filename =~ /access_statistics/) {
#	$stats++;
#    }

    
    $r->send_http_header;
    return OK if $r->header_only;
    
    my $boilerplate = Boilerplate->new();
    my $style;
    if ($r->filename =~ /index\.html/) {
	$style = '/css/bookworm.css';
    } elsif ($r->filename =~ /announce\.html/ || $r->filename =~ /sponsors\.html/ 
	     || $r->filename =~ /about\.html/ 
	     || $r->filename =~ /citewb\.html/ 
	     || $r->filename =~ /wbg\.html/ 
	     || $r->filename =~ /wli\.html/ 
	     || $r->filename =~ /wbg_instructions\.html/ 
	     || $r->filename =~ /authorinfo\.html/
	     || $r->filename =~ /mailarch/  
	     || $r->filename =~ /search\.html/
	     || $r->filename =~ /not_found\.html/
	     || $r->filename =~ /newsarchive\.html/
	     || $r->filename =~ /photocredits\.html/
	     || $r->filename =~ /toc_/           # keeps css correct for subsection table of contents
	     ) {
	
	$style = '/css/bookworm.css';
    } elsif ($r->filename =~ /docbook/ ) {
	$style = undef;
    } else {
	$style = '/css/article.css';
    }
    
    
    my $boiler = 0; #don't show boilerplates (header, footer)
    
    # No header for the WLI/WBG archives
    if ($r->filename =~ /wli/) {
	$boiler = 'off';
    }
    
    # No header for stats pages
    my $stats;
    if ($r->filename =~ /access_statistics/) {
	$boiler = 'off';
	$stats++;
    }
    
    
    while (<$fh>) {
	if (m/noboiler/ || $boiler eq 'off') {
	    $r->print($_);
	    $boiler = 'off';
	    next;
	}
	if (m!</head(.*)!) {
	    if ($style) {
		$r->print(qq(<link rel="stylesheet" href="$style" />\n));
	    }  
	    $r->print(qq(<script language="JavaScript" type="text/javascript" src="/js/highlightTerms.js"></script>\n));
	}

	if (/<body(.*)>/i) {
	    if ($style eq '/css/article.css') {
		$_ =~ s/$1>/$1 onload='highlightIgorSearchTerms(document.referrer);'>/;
	    }
	    else {
		$_ =~ s/$1>/$1 onload='highlightIgorSearchTerms(document.referrer);'><div id="container">/;
	    }
	}
	
    # so that we can turn off the auto-added header if need be
	if ($stats) {
	    $r->print($_);
	    next;
	} elsif (m!<body(.*)>!i && (!m/noboiler/i)) {
	    $boiler = 1;
	    $r->print($_);
	    $r->print($boilerplate->banner());
	    next;
	} elsif (m!</body.*>!i && $boiler) {
	    $r->print($boilerplate->footer());
	    return OK;
	}
	$r->print($_);
    }
    return OK;
}

1;

