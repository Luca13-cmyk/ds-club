



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










  

}); // JS 








