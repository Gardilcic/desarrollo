
	<style>
	body{
		font: normal 13px Arial;	
		padding-top: 20px;
	}
	.barra{
		background: url('libs/img/barra.jpg') center repeat-y; 
		background-color: #EEE; border: 0px;
		height: 8px;
	}
	.derecha{
		text-align:right;
	}
	.color-negro{
		font-weight: bold;
		color: black;
	}
	.color-verde{
		font-weight: bold;
		color: #5c9a4d;
	}
	.color-plomo{
		color: #b5b5b5;
	}
	#carousel {
		width:800px;
		height: 130px;
		display: relative;
		margin: 0 auto;
	}
	#carousel img {
		display: hidden; /* hide images until carousel prepares them */
		cursor: pointer; /* not needed if you wrap carousel items in links */
	}
	th.headerSortUp { 
	    background-image: url('libs/img/asc.gif'); 
	    background-repeat: no-repeat;
	    background-position: 95%;
	} 
	th.headerSortDown { 
	    background-image: url('libs/img/desc.gif'); 
	    background-repeat: no-repeat;
	    background-position: center right; 

	} 
	th.header {  
		/*background-image: url('libs/img/bg.gif');   */  
	    cursor: pointer; 
	    font-weight: bold; 
	    background-repeat: no-repeat; 
	    background-position: center right; 
	    border-right: 1px solid #dad9c7; 
	    margin-left: -1px; 
	    background-color: #EEE;

	} 
	    
	</style>  

	<div class="navbar navbar-fixed-top">
      <div class="barra">
        <div class="container" style="width:80%;"></div>
      </div>
    </div>
