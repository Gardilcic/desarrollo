$(document).ready(function () {
    var numero_turnos = 80;
    /*var data = [
    	{ 
    		"idActividad": "1", 
    		"nombreActividad": "Perforacion de tunel en calle 12", 
    		"unidadActividad": "ML",
    		"alcanceActividad": "1000",
    		"realActividad": "70",
    		"diferenciaActividad": "30",
    		"t1": "3",
    		"t2": "6",
    		"t3": "7",
    		"t4": "2",
    		"t5": "3",
    		"t6": "4",
    		"t7": "6",
    		"t8": "1",
    		"t9": "4",
    		"t10": "3",
    		"t11": "3",
    		"t12": "6",
    		"t13": "7",
    		"t14": "2",
    		"t15": "3",
    		"t16": "4",
    		"t17": "6",
    		"t18": "1",
    		"t19": "4"                	
    	}
    ];*/

    var data = [];
    for(var i=1; i<=numero_turnos; i++) {
   		
   		var valor = 0;
   		valor = Math.round(Math.random() * 10) + 1;

   		var objeto = {
    		idActividad : '1', 
    		nombreActividad : 'Perforacion de tunel en calle '+valor,
    		unidadActividad : 'ML',
    		alcanceActividad : '1000',
    		realActividad : '70',
    		diferenciaActividad : '30'
    	};
    		        	
		for(var x=1; x<=numero_turnos; x++) {
			var nombre = 't'+x;
			valor = Math.round(Math.random() * 10);
			objeto["t"+x] = valor;
   		}
   		
	    data.push( objeto );
    }

	var campos = [
            { name: 'idActividad', type: 'string' },
            { name: 'nombreActividad', type: 'string' },
            { name: 'unidadActividad', type: 'number' },	
            { name: 'alcanceActividad', type: 'number' },
            { name: 'realActividad', type: 'number' },   
            { name: 'diferenciaActividad', type: 'number' }
    	];
    	
	for(var i=1; i<=numero_turnos; i++) {
	    campos.push({ name: 't'+i, type: 'number' });
    }
    
    var source =
    {
        localdata: data,
        datatype: "json",
        datafields: campos
    };
    
	

    var dataAdapter = new $.jqx.dataAdapter(source);
    
	var columnas = [
          { text: 'Actividad', columntype: 'textbox', datafield: 'nombreActividad', width: 400, editable: false, pinned: true, align: 'center' },
          { text: 'Unidad', columntype: 'textbox', datafield: 'unidadActividad', width: 60, editable: false, pinned: true, align: 'center' },
          { text: 'Alcance', columntype: 'textbox', datafield: 'alcanceActividad', width: 90, editable: false, pinned: true, align: 'center', cellsalign: 'right', cellsformat: 'f2' },
          { text: 'Real', columntype: 'textbox', datafield: 'realActividad', width: 80, editable: false, pinned: true, align: 'center', cellsalign: 'right', cellsformat: 'f2' },
		  { text: 'Diferencia', columntype: 'textbox', datafield: 'diferenciaActividad', width: 80, editable: false, pinned: true, align: 'center', cellsalign: 'right', cellsformat: 'f2'  },
		];
        
    var c_turnos = 1;
	for(var i=1; i<=numero_turnos; i++) {
		if(c_turnos > 2) {
	    	columnas.push({ text: 'T'+i, cellclassname: 'resaltado', columntype: 'textbox', datafield: 't'+i, width: 60, align: 'center', cellsalign: 'right', cellsformat: 'f2' });
	    	if(c_turnos > 3) {
	    		c_turnos=0;
	    	}
	    	c_turnos ++;
	    } else {
	    	columnas.push({ text: 'T'+i, columntype: 'textbox', datafield: 't'+i, width: 60, align: 'center', cellsalign: 'right', cellsformat: 'f2' });
	    	c_turnos ++;
	    }
    }
    //alert(columnas.length);
        
    // initialize jqxGrid
    $("#jqxgrid").jqxGrid(
    {
        width: 1170,
        source: dataAdapter,
        editable: true,
        selectionmode: 'multiplecellsadvanced',
        columns: columnas
    });
    
    // events
    $("#jqxgrid").on('cellbeginedit', function (event) {
        var args = event.args;            	                
        $("#cellbegineditevent").text(">>> Event Type: cellbeginedit, Column: " + args.datafield + ", Row: " + (1 + args.rowindex) + ", Value: " + args.value);
    });

    $("#jqxgrid").on('cellendedit', function (event) {
        var args = event.args;
        $("#jqxgrid").jqxGrid('setcellvalue', (args.rowindex), args.datafield, args.value);
		
		var contador = 0;
        var nroColumnas = $("#jqxgrid").jqxGrid('columns').records.length - 5;
        var total = 0;
                
        for(contador=1; contador<=nroColumnas; contador++) {
        	var valor = $("#jqxgrid").jqxGrid('getcellvalue', (args.rowindex), "t"+contador );
        	if(!isNaN(valor))
        		total += valor;
        	//alert(valor);
		}
		
		var diferencia = $("#jqxgrid").jqxGrid('getcellvalue', (args.rowindex), "alcanceActividad") - total;
		
		$("#jqxgrid").jqxGrid('setcellvalue', (args.rowindex), "realActividad", total );
		$("#jqxgrid").jqxGrid('setcellvalue', (args.rowindex), "diferenciaActividad", diferencia );
    });
});
