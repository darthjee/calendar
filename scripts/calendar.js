/**
 * @brief valida um formulario
 */
function validateForm(form)
{
  return $(form).validateForm('required', 'alert');
}

/**
 * @brief checa se o formulario de login esta correto
 */
function checkLogin(form)
{
  /* preparacao do div de retorno */
  var selector = $(form).attr("return");
  /* quando o formulario nao foi bem preenchido, este causa um erro */
  if ($(form).validateForm('required', 'alert') != true)
  {
    alert('voce deve preencher todos os campos do formulario');
    return false;
  }
  else
  {
    /* encriptacao da senha */
    input = $(form).find("input[type='password']");
    input.each(function ()
    {
      var ipt = $(this);
      var md5 = MD5(ipt.val());
      ipt.val('');
      var idcrpt = ipt.attr('id')+'-crypt';
      $("input#"+idcrpt).val(md5);
    });
  }
  return true;
}

/**********************
 * Events Watchers
 */

/**
 * @brief evento que observa o submit de todos os formularios do tipo ajax
 */
jQuery("form.ajax, form.ajax input.ajax").live('submit',
/**
 * @brief funcao ativada com o submit de todos os formularios do tipo ajax
 */
function watchAjaxForm(){
  var form = $(this);
  formdom = this;
  /* busca do formulario verdadeiro */
  if (!form.is("form"))
    form = form.findParent("form");

  /* pegando o seletor de retorno */
  var rsel = form.attr("return");
  if (rsel == null)
  {
    div = $(this).findParent("div");
    rsel = "div#"+div.attr("id");
  }

  /* chamada da funcao validadora (declarada no formulario) */
  var precall = form.attr("validate");
  if (precall != null && precall.length > 0)
  {
    precall = precall.replace(/([(, ])this([), \.])/g, '$1formdom$2');
    eval("var cont=function(){"+precall+"}();");
  }
  else
    var cont = true;
  /* quand cont == true, o formulario eh considerado valido */
  if (cont == true)
  {
    form.removeClass("ajax");
    form.ajaxFormSubmit(rsel);
    form.addClass("ajax");
  }
});

/**
 * @brief evento que observa os links do tipo ajax
 */
jQuery("a.ajax").live('click',
/**
 * @brief funcao ativada com o submit de todos os formularios do tipo ajax
 */
function watchAjaxLink(){
  var link = $(this);
  linkdom = this;
  var url = link.attr("href");
  var target = link.attr("target");
  $(target).load(url);
});

