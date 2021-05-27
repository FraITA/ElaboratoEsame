/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function openPage(page){
	window.location.assign(page);
}

function toggleForm(value){
	
	var carta		= $("#form_carta");
	var conto		= $("#form_conto");
	var carta_cred	= $("#carta_cred");
	var cod_cred	= $("#cod_cred");
	var data_scad	= $("#data_scad");
	var iban		= $("#iban");
	
	if(value === "Carta credito"){
		conto.hide();
		carta.show();
		iban.attr("required", false);
		carta_cred.attr("required", true);
		cod_cred.attr("required", true);
		data_scad.attr("required", true);
	}else{
		carta.hide();
		conto.show();
		carta_cred.attr("required", false);
		cod_cred.attr("required", false);
		data_scad.attr("required", false);
		iban.attr("required", true);
	}
}

function getPagamenti(select){
	$("#delete").remove();
	var serv = select.value;
	
	$.ajax({
		url : "getPagamenti.php",
		method : "GET",
		data : { servizio :  serv },
		success : function(data) {
			$("#pagamenti").html(data);
		}
	});
}