var softwareupdate_seed = function(colNumber, row){

    var col = $('td:eq('+colNumber+')', row),
        colvar = col.text();

    colvar = colvar == '3' ? '<span class="label label-warning">'+i18n.t('softwareupdate.publicseed')+'</span>' :
    colvar = colvar == '2' ? '<span class="label label-danger">'+i18n.t('softwareupdate.developerseed')+'</span>' :
    colvar = colvar == '1' ? '<span class="label label-warning">'+i18n.t('softwareupdate.customerseed')+'</span>' :
    (colvar === '0' ? '<span class="label label-success">'+i18n.t('softwareupdate.unenrolled')+'</span>' : colvar)
    col.html(colvar)
}


var format_softwareupdate_yes_no = function(colNumber, row){
    var col = $('td:eq('+colNumber+')', row),
        colvar = col.text();
    colvar = colvar == '0' ? '<span class="label label-success">'+i18n.t('No')+'</span>' :
    colvar = (colvar == '1' ? '<span class="label label-danger">'+i18n.t('Yes')+'</span>' : colvar)
    col.html(colvar)
}

var format_softwareupdate_yes_no_rev = function(colNumber, row){
    var col = $('td:eq('+colNumber+')', row),
        colvar = col.text();
    colvar = colvar == '0' ? '<span class="label label-danger">'+i18n.t('No')+'</span>' :
    colvar = (colvar == '1' ? '<span class="label label-success">'+i18n.t('Yes')+'</span>' : colvar)
    col.html(colvar)
}

var format_softwareupdate_updates_available = function(colNumber, row){
    var col = $('td:eq('+colNumber+')', row),
        colvar = col.text();
    colvar = colvar == '0' ? '<span class="label label-success">'+colvar+" "+i18n.t('softwareupdate.updates')+'</span>' :
    colvar = colvar == '1' ? '<span class="label label-danger">'+colvar+" "+i18n.t('softwareupdate.update')+'</span>' :
    colvar = (colvar > '1' ? '<span class="label label-danger">'+colvar+" "+i18n.t('softwareupdate.updates')+'</span>' : colvar)
    col.html(colvar)
}

var format_softwareupdate_ddm_info = function(colNumber, row){
    var col = $('td:eq('+colNumber+')', row),
        colvar = col.text();
    col.text(colvar.replaceAll("\n", ", "))
}

// Filters
var ManagedDeferralCounterFilter = function(colNumber, d){
    
    // Look for 'between' statement todo: make generic
    if(d.search.value.match(/^\d deferCount \d$/))
    {
        // Add column specific search
        d.columns[colNumber].search.value = d.search.value.replace(/(\d) deferCount (\d)/, function(m, from, to){return ' BETWEEN ' + (from) + ' AND ' + (to)});
        // Clear global search
        d.search.value = '';
    }

    // Look for a bigger/smaller/equal statement
    if(d.search.value.match(/^deferCount [<>=] \d$/))
    {
        // Add column specific search
        d.columns[colNumber].search.value = d.search.value.replace(/.*([<>=] )(\d)$/, function(m, o, content){return o + (content)});
        // Clear global search
        d.search.value = '';
    }
}

var uptodateFilter = function(colNumber, d){
    // Look for 'not_safety_frozen' keyword
    if(d.search.value.match(/^macos_updtodate$/))
    {
        // Add column specific search
        d.columns[colNumber].search.value = '= 0';
        // Clear global search
        d.search.value = '';
    }

    // Look for 'safety_frozen' keyword
    if(d.search.value.match(/^macos_not_updtodate$/))
    {
        // Add column specific search
        d.columns[colNumber].search.value = '!= 0';
        // Clear global search
        d.search.value = '';
    }
}