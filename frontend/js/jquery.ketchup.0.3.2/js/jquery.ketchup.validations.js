jQuery.ketchup

.validation('required', 'This field is required.', function(form, el, value) {
//.validation('required', 'Este campo es requerido.', function(form, el, value) {
  var type = el.attr('type').toLowerCase();
  
  if(type == 'checkbox' || type == 'radio') {
    return (el.attr('checked') == true);
  } else {
    return (value.length != 0);
  }
})

.validation('minlength', 'This field must have a minimal length of {arg1}.', function(form, el, value, min) {
//.validation('minlength', 'Este campo debe tener una longitud mínima de {arg1}.', function(form, el, value, min) {
  return (value.length >= +min);
})

.validation('maxlength', 'This field must have a maximal length of {arg1}.', function(form, el, value, max) {
//.validation('maxlength', 'Este campo debe tener una longitud máxima de {arg1}.', function(form, el, value, max) {
  return (value.length <= +max);
})

.validation('rangelength', 'This field must have a length between {arg1} and {arg2}.', function(form, el, value, min, max) {
//.validation('rangelength', 'Este campo debe tener una longitud entre {arg1} y {arg2}.', function(form, el, value, min, max) {
  return (value.length >= min && value.length <= max);
})

.validation('min', 'Must be at least {arg1}.', function(form, el, value, min) {
//.validation('min', 'Debe ser al menos {arg1}.', function(form, el, value, min) {
  return (this.isNumber(value) && +value >= +min);
})

.validation('max', 'Can not be greater than {arg1}.', function(form, el, value, max) {
//.validation('max', 'No puede ser mayor que {arg1}.', function(form, el, value, max) {
  return (this.isNumber(value) && +value <= +max);
})

.validation('range', 'Must be between {arg1} and {arg2}.', function(form, el, value, min, max) {
//.validation('range', 'Debe estar entre {arg1} y {arg2}.', function(form, el, value, min, max) {
  return (this.isNumber(value) && +value >= +min && +value <= +max);
})

.validation('number', 'Must be a number.', function(form, el, value) {
//.validation('number', 'Debe ser un número.', function(form, el, value) {
  return this.isNumber(value);
})

.validation('digits', 'Must be digits.', function(form, el, value) {
//.validation('digits', 'Debe ser dígitos.', function(form, el, value) {
  return /^\d+$/.test(value);
})

.validation('email', 'Must be a valid E-Mail.', function(form, el, value) {
//.validation('email', 'Debe ser un E-Mail válido.', function(form, el, value) {
  return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(value);
  //return this.isEmail(value);
})

.validation('url', 'Must be a valid URL.', function(form, el, value) {
//.validation('url', 'Debe ser una URL válida.', function(form, el, value) {
  return this.isUrl(value);
})

.validation('username', 'Must be a valid username.', function(form, el, value) {
//.validation('username', 'Debe ser un nombre de usuario válido.', function(form, el, value) {
  return this.isUsername(value);
})

.validation('match', 'Must be {arg1}.', function(form, el, value, word) {
//.validation('match', 'Debe ser igual al campo {arg1}.', function(form, el, value, word) {
  //return (el.val() == word);
  return (value == $("#txtClave").val());
})

.validation('contain', 'Must contain {arg1}', function(form, el, value, word) {
//.validation('contain', 'Debe contener {arg1}', function(form, el, value, word) {
  return this.contains(value, word);
})

.validation('date', 'Must be a valid date.', function(form, el, value) {
//.validation('date', 'Debe ser una fecha válida.', function(form, el, value) {
  return this.isDate(value);
})

.validation('minselect', 'Select at least {arg1} checkboxes.', function(form, el, value, min) {
//.validation('minselect', 'Seleccione al menos {arg1} casillas.', function(form, el, value, min) {
  return (min <= this.inputsWithName(form, el).filter(':checked').length);
}, function(form, el) {
  this.bindBrothers(form, el);
})

.validation('maxselect', 'Select not more than {arg1} checkboxes.', function(form, el, value, max) {
//.validation('maxselect', 'Seleccione no más de {arg1} casillas.', function(form, el, value, max) {
  return (max >= this.inputsWithName(form, el).filter(':checked').length);
}, function(form, el) {
  this.bindBrothers(form, el);
})

.validation('rangeselect', 'Select between {arg1} and {arg2} checkboxes.', function(form, el, value, min, max) {
//.validation('rangeselect', 'Seleccione entre {arg1} y {arg2} casillas.', function(form, el, value, min, max) {
  var checked = this.inputsWithName(form, el).filter(':checked').length;
  
  return (min <= checked && max >= checked);
}, function(form, el) {
  this.bindBrothers(form, el);
});