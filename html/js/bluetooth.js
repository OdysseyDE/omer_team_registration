oTable = null;

$(document).ready(function() {
    $('.focused').focus().select();

    $('#beacons').DataTable( {
        stateSave: true,
        stateDuration: 0,
        order: [[0,'desc']],
        language: { url: ermittleDatatablesSprachfile() },
        "aoColumns": [
            null,
            null
        ]
    });
    
    $('#clients').DataTable( {
        stateSave: true,
        stateDuration: 0,
        order: [[0,'desc']],
        language: { url: ermittleDatatablesSprachfile() },
        "aoColumns": [
            null,
            null
        ]
    });
    
    $('#positions').DataTable( {
        stateSave: true,
        stateDuration: 0,
        language: { url: ermittleDatatablesSprachfile() },
        columnDefs: [
            {
                targets: [3],
                orderData: [5]
            },
            {
                targets: [4],
                orderData: [6]
            },
            {
                "visible": false,
                "targets": [5,6],
                "className": "never"
            }
        ]
    });

    $('.datepicker').datepicker( { 
        showButtonPanel: false,
        regional: "de"
    });

    $('.standardValidation').validate({
            errorPlacement: function(error, element) {}
    });

    tableClicks();
});

function ermittleSprache ( ) {
    var lang = "de";
    if ( $('#interfaceLanguage')[0] )
        lang = $('#interfaceLanguage').val();
    return lang;
}

function ermittleDatatablesSprachfile ( ) {
    var file = "/js/language_support/dataTable_" + ermittleSprache() +".txt";
    return file;
}

function tableClicks ( ) {
    $('table.clickable tbody tr').click(function(e) {
        clickOnTable(e);
    });
}

function clickOnTable ( event ) {
    var target = $(event.target);
    var tr = target.closest('tr');
    var id = tr.attr('id');
    var parts = self.location.href.split('?');
    var params = parts[1].split('&');
    var newUrl = [parts[0] + '?'];
    var newAction = '';

    if ( target.attr('type') == 'button' ) {
        newAction = 'action=Delete&Id=' + id;
    } else {
        newAction = 'action=Edit&Id=' + id;
    }

    $.each(params,function(index,item) {
        if ( item.search('action') == 0 )
            newUrl.push(newAction);
        else
            newUrl.push(item);
    });
    
    newUrl = newUrl.join('&');

    if ( target.attr('type') == 'button' ) {
        $.ajax({
	    url: newUrl,
	    success: function( data ) {
                if ( checkLogout(data) ) {
                    oTable.row(tr).remove().draw();
                    showResponse(uebersetze('gelöscht'));
                }
            }
        });
    } else {
        self.location.href = newUrl;
    }
}
