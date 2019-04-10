
if(isset($_POST['data_File']))
{
update_XML_File_Process();
}
else if(isset($_GET['rn']))
{
delete_Process();
}
else if(isset($_POST['change_file']))
{
display_Process();
}
else
{
select_File_Process();
}
