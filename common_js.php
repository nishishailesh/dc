<?php

echo '<script>

function run_ajax(str,rid)
{
	//create object
	xhttp = new XMLHttpRequest();
	
	//4=request finished and response is ready
	//200=OK
	//when readyState status is changed, this function is called
	//responceText is HTML returned by the called-script
	//it is best to put text into an element
	xhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		document.getElementById(rid).innerHTML = this.responseText;
	  }
	};

	//Setting FORM data
	xhttp.open("POST", "save_dc.php", true);
	
	//Something required ad header
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	
	// Submitting FORM
	xhttp.send(str);
	
	//used to debug script
	//alert("Used to check if script reach here");
}

function make_post_string(id,t)
{
	k=t.id;
	v=encodeURIComponent(t.value);					//to encode almost everything
	post=\'field=\'+k+\'&value=\'+v+\'&id=\'+id;
	//post=post.replace(/\+/g,\'%2B\');
	return post;							
}

function do_work(id,t)
{
	str=make_post_string(id,t);
	//alert(post);
	run_ajax(str,\'response\');
}

function getfrom(one,two) {
			document.getElementById(two).value =one.value;
		}
	

function hide(one) {
				document.getElementById(one).style.display = "none";
		}

			
</script>
<script type="text/javascript" src="date/datepicker.js"></script>
<link rel="stylesheet" type="text/css" href="date/datepicker.css" /> 
';


echo '<script type="text/javascript" >
		function showhide(one) {
			if(document.getElementById(one).style.display == "block")
			{
				document.getElementById(one).style.display = "none";
			}
			else
			{
				document.getElementById(one).style.display = "block";
			}	
		}
		</script>';

echo '

<style>
	.menu {border:0px;border-spacing: 0;border-collapse: collapse;background-color:lightgreen;}
</style>

<script type="text/javascript" >
		function showhidemenu(one) 
		{		
			xx=document.getElementsByClassName(\'menu\');			
			for(var i = 0; i < xx.length; i++)
			{
				if(xx[i]!=document.getElementById(one))
				{
					xx[i].style.display = "none";		
				}
				
				else if(xx[i]==document.getElementById(one))
				{
					if(xx[i].style.display == "block")
					{
						xx[i].style.display = "none";
					}
					else
					{
						xx[i].style.display = "block";
					}		
				}
			}	
		}
		
		function hidemenu() {
		
			xx=document.getElementsByClassName(\'menu\');
			for(var i = 0; i < xx.length; i++)
			{
				xx[i].style.display = "none";		
			}
		}
		
		//document.onclick=function(){hidemenu();};
		</script>';

echo '
<style>
	
table{
   border-collapse: collapse;
}

.border td , .border th{
    border: 1px solid gray;
}

.upload{
	background-color:lightpink;	
}

.lightgray{
	background-color:lightgray;	
}

.lightblue{
	background-color:lightblue;	
}

.noborder{
 border: none;
}


.hidedisable
{
	display:none;diabled:true
}

.section_header
{
	background-color:gray;
}
</style>';		
		
?>
