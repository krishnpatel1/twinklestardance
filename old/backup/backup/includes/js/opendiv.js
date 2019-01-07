function openDiv(id)
{
	closeDiv();
	document.getElementById("s"+id).style.display="block";

}
function closeDiv()
{
	for(var i=1;i<=20;i++)
	{
		if(document.getElementById("s"+i))
		{
			document.getElementById("s"+i).style.display="none";
		}
	}
}
