



var $offset_area_per = $('.offset-area-per');
if (window.screen.width > 1200)
{
  
  $offset_area_per.perfectScrollbar(); // perfect scroll
}


$(function(){



// ########### Variaveis


$close_button = $(".offset-close");
$data_settings_per = $("a[data-settings_per]");
$md = $("md-backdrop");

// ############ Plugins



// ################ Events




$close_button.on("click", function(e){
 e.preventDefault();
 e.stopPropagation();

$offset_area_per.removeClass("show_hide");
$md.hide();

});
$md.on("click", function(e){
  e.preventDefault();
  e.stopPropagation();
 
 $offset_area_per.removeClass("show_hide");
 $(this).hide();
 
 });

$data_settings_per.on("click", function(e){
  e.preventDefault();
  e.stopPropagation();
  
 $offset_area_per.addClass("show_hide");
 $md.show();
 });

 setInterval(function(){
  $("a[data-next_slide_cub]").click();

 }, 6000);


//  ############ animation scroll

$("a[data-animation_scroll]").on("click", function(e){
  
  $("html, body").animate({
      scrollTop: $($(this).attr("href")).offset().top
  }, 800, "linear");
  return false

});

// ############# Dark mode

var dark = document.getElementById("switch1");

var html = document.querySelector("html");

var sidebar = document.querySelector(".sidebar");




if (localStorage.dark)
{
  html.classList.add(localStorage.dark);
  sidebar.setAttribute("data-color", "black");
  dark.click();
}


dark.addEventListener("click", function(){


  if (this.checked)
  {
    localStorage.dark = "dark";
    html.classList.add(localStorage.dark);
    sidebar.setAttribute("data-color", "black");
    
  }
  else
  {
    html.classList.remove(localStorage.dark);
    sidebar.setAttribute("data-color", "white");
    localStorage.dark = "";
  }


}, false );

// ####################### pagination



// Testes
// for (let index = 0; index < 45; index++) {
//   if (index == 14)
//   {
//     $("#pagination_per").append('<li class="pageNumber current"><a class="" href="#">' + index  + '</a></li>');
//     continue;

//   }
//   $("#pagination_per").append('<li class="pageNumber "><a class="" href="page-link">' + index  + '</a></li>');
// }

// ./Testes

var $paginationCurrent = $("#pagination_per li.current");
var $pagination = $("#pagination_per");

$paginationCurrent.prev().prev().prevAll().hide();

$paginationCurrent.next().next().next().
next().next().next().
next().next().next().next().
next().next().
nextAll().hide();

$pagination.append('<li><a href="#" class="next">Next</a></li>');
$pagination.prepend('<li><a href="#" class="prev"> Prev</a></li>');

//  if ($paginationCurrent.prevAll().length > 2)
//  {

  

//  }


$("li[data-search_pagination_next]").on("click", function(){

  alert();

});
$("li[data-search_pagination_prev]").on("click", function(){

  alert();

});


// ############## AUTOCOMPLETE & FILTER


 if (document.getElementById("Filtro"))
 {
    // **** Filtro
  var l = Lonely;
  var inp = document.getElementById("Filtro");

  var nomes = [];
  $name_topic = $("a[data-name_topic");


  $name_topic.each(function(index){
    nomes.push($(this).attr("data-name_topic"));
  });

  l.autocomplete(inp, nomes);
  // **** End filtro Barra Dicas

  // var $downloads = $(".card");
  var $filter = $("#Filtro");
  var cache = [];

  $name_topic.each(function(){
    cache.push({
      element:this,
      text:this.getAttribute("data-name_topic").trim().toLowerCase()
    })
  })
  console.table(cache)

  function filter(){
    var query = this.value.trim().toLowerCase();
    cache.forEach(function(fil){
      var index = 0;
      if (query){
        index = fil.text.indexOf(query);
      }
      fil.element.style.display = index === -1 ? 'none' : '';

    }); //forEach

  } // Filter
  if ('oninput' in $filter[0]){
    $filter.on("input keyup", filter);
  } else {
    $filter.on("keyup", filter);
  }

  // End Filtro


 }



//  ##################### AJAX ######################

var AZ = document.getElementById("ajaxAZ");
var ajaxAZsubmit = document.getElementById("ajaxAZsubmit");
var valueAJAXAZ = document.getElementById("valueAJAXAZ");
var statusAZ = document.getElementById("statusAZ");

if (AZ && ajaxAZsubmit)
  {

    ajaxAZsubmit.addEventListener("submit", function(e){


      e.preventDefault();
      var value = valueAJAXAZ.value;

      if (value == "") return;

      AZ.innerHTML = ""; // limpa o historico, para n acumular requisicoes.
      var xhr = new XMLHttpRequest(); // faz a requisicao.
      
      
        xhr.onload = function()
  
        {
          //######## testes
          // console.log(xhr.response.length);
          // console.log(xhr.response);
          // response = xhr.response;
          // #######
          
          if (xhr.status === 200)
          {
            try {
              statusAZ.style.display = "none";
              responseObject = JSON.parse(xhr.responseText);
              
              const r = responseObject;
              console.table(r);
              
              
              
              // Quantidade de visualizacoes
              // document.querySelector("p[data-nqnt]").innerHTML = "Atual: " + r[1];

              // Ultima atualizacao
              // var d = new Date();
              // document.querySelector("i[data-update-per-visitas]").innerHTML = " Ultima atualizacao:  " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();

              
              

              // Execucao no content
              

              for (let index = 0; index < r.length; index++) {
                
                AZ.innerHTML +=  "<div  class='item' title='" + r[index].destopic + "'>" +
                 "<button data-toggle='tooltip' data-placement='bottom' title='Adicionar aos favoritos' id='add_fav_slider_topic'><i class='nc-icon nc-bookmark-2'></i></button>"
                 +
                 "<div class='shadow-effect'><img src='" + r[index].descap + "' alt='cap'></div>" 
                 +
                 "<a href='" + r[index].idtopic + "'><div class='testimonial-name'>Recomendado</div></a>"; 
                
            
              }
              
            
            } catch (error) {
              // document.querySelector("p[data-error_per]").innerHTML = 2;
              // document.getElementById("show_error_code_trycatch_ajax").innerHTML = error.name;
            }
            
          } else 
          {
            // document.querySelector("p[data-error_per]").innerHTML = 1;
            // document.getElementById("show_error_code_ajax").innerHTML = xhr.status;
          }
          
          
  
        }

        
      xhr.open("GET", "https://lds-club-com.umbler.net/data/ajax/AZ?l=" + value, true);
      xhr.send(null);




    }, false); // evento ajax para atualizar.
    
      
  }







  

}); // JS 








