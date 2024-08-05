
function enable_delete(confirm_message, none_selected_message)
{

    //Keep track of enable_delete has been called
    if (!enable_delete.enabled)
        enable_delete.enabled = true;

    $('#delete').click(function (event)
    {
        event.preventDefault();
        
        var $this = $(this);

        var selected = new Array();
        $('input[name="chk[]"]:checked').each(function () {
            selected.push($(this).val());
        });

        if (selected.length > 0)
        {
            alertify.confirm(confirm_message, onOk)
            function onOk()
            {
                do_delete($this.attr('href'));
            }
        }
        else
        {
            alertify.alert(none_selected_message);
        }
    });
}
enable_delete.enabled = true;

function do_delete(url)
{
    //If delete is not enabled, don't do anything
    if (!enable_delete.enabled)
        return;

    var row_ids = get_selected_values();

    $.post(url, {'ids[]': row_ids, "softtoken" : $('#token_hash').val()}, function (response)
    {
        console.log(response.ids)
        //delete was successful, remove checkbox rows
        if (response.success)
        {
            //get_data();
            set_feedback(response.message, 'success_message', false);
        }
        else
        {
            set_feedback(response.message, 'error_message', true);
        }

    }, "json");
}



function get_selected_values()
{
    var selected_values = new Array();
    $('input[name="chk[]"]:checked').each(function () {
        selected_values.push($(this).val());
    });

    return selected_values;
}

function get_selected_rows()
{
    var selected_rows = new Array();
    $("#datatable tbody :checkbox:checked").each(function ()
    {
        selected_rows.push($(this).parent().parent());
    });
    return selected_rows;
}
