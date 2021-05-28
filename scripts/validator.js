/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var error_mess = "";

function validate_form_reg(form){
	error_mess = "";
	if(!validate_cod_fiscale(form.cod_fis.value)){
		error_mess += "Codice fiscale non valido\n";
	}
	if(!validate_email(form.email.value)){
		error_mess += "Email non valida\n";
	}
	if(!validate_tel(form.telefono.value)){
		error_mess += "Numero di telefono non valido\n";
	}
	if(!validate_data_nascita(form.data_nasc.value)){
		error_mess += "Data di nascita non valida\n";
	}
	if(!validate_num_civ(form.num_civ.value)){
		error_mess += "Numero civico non valido\n";
	}
	
	
	if(!validate_text(form.nome.value)){
		error_mess += "Nome non valido\n";
	}
	if(!validate_text(form.cognome.value)){
		error_mess += "Cognome non valido\n";
	}
	if(!validate_text(form.indirizzo.value)){
		error_mess += "Indirizzo non valido\n";
	}
	if(!validate_text(form.comune.value)){
		error_mess += "Campo comune non valido\n";
	}
	if(!validate_text(form.provincia.value)){
		error_mess += "Campo provincia non valido\n";
	}
	
	

	if(error_mess.length > 0){
		alert(error_mess);
		return false;
	}else{
		return true;
	}
}

function validate_form_login(){
	error_mess = "";
	
	if(!validate_email(form.email.value)){
		error_mess += "Email non valida\n";
	}
	
	if(error_mess.length > 0){
		alert(error_mess);
		return false;
	}else{
		return true;
	}
}

function validate_form_contratto(){
	error_mess = "";
	
	if(form.tipo_pag.value == "Carta credito"){
		if(!validate_carta_cred(form.carta_cred.value)){
			error_mess += "Numero carta di credito non valido\n";
		}

		if(!validate_num_carta(form.cod_cred.value)){
			error_mess += "Codice carta di credito non valido\n";
		}
	}else{
		if(!validate_iban(form.iban.value)){
			error_mess += "IBAN non valido\n";
		}
	}
	
	if(error_mess.length > 0){
		alert(error_mess);
		return false;
	}else{
		return true;
	}
}

function validate_cod_fiscale(string){
	var letters = /^[A-Z]{6}[0-9]{2}[A-Z]{1}[0-9]{2}[A-Z]{1}[0-9]{3}[A-Z]{1}$/s;

	return(letters.test(string));

}

function validate_email(string){
	var letters = /^[A-Za-z0-9-._!?$&%£]+\@[a-z0-9-_]+\.[a-z0-9]{2,}$/s;

	return(letters.test(string));
}

function validate_tel(string){
	var letters = /^[0-9]{10}$/s;

	return(letters.test(string));
}

function validate_data_nascita(string){
	var letters = /^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/s;
	
	return(letters.test(string));
}

function validate_num_civ(string){
	var letters = /^[0-9A-Z\/]+$/s;

	return(letters.test(string));
}

function validate_cod_carta(string){
	var letters = /^[0-9]{3}$/s;
	
	return(letters.test(string));
}

function validate_num_carta(string){
	var letters = /^[0-9]{16}$/s;
	
	return(letters.test(string));
}

function validate_text(string){
	var letters = /^[A-Za-zèòàù ]{0,30}$/s;

	return(letters.test(string));
}

function validate_iban(string){
	var letters = /^[A-Za-zèòàù ]{0,30}$/s;

	return(letters.test(string));
}

