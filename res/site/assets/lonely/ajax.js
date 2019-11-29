(function(){

    //  ##################### AJAX ######################

var AZ = document.getElementById("ajaxAZ");
var ajaxAZsubmit = document.getElementById("ajaxAZsubmit");
var valueAJAXAZ = document.getElementById("valueAJAXAZ");
var statusAZ = document.getElementById("statusAZ");
var topicsAZAJAXcontent = document.getElementById("topicsAZAJAXcontent");

if (AZ && ajaxAZsubmit)
  {

    ajaxAZsubmit.addEventListener("submit", function(e){


      e.preventDefault();
      var value = valueAJAXAZ.value;

      if (value == "") return;
      if (value.length > 1) return;

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
              topicsAZAJAXcontent.style.display = "block";
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
                
                // AZ.innerHTML +=  "<a href='/topics/" + r[index].idtopic + "'><li class='list-group-item'>" +  r[index].destopic  + "</li></a>"; 

                AZ.innerHTML += '<div class="col-lg-6 col-md-12 mb-5 d-md-flex justify-content-between">' + 
                
                                '<div class="avatar mb-md-0 mb-4 mx-4">' +

                                '<img src="' + r[index].descap + '" class="rounded z-depth-1" alt="'+ r[index].destopic  + '">' +

                                '</div>' +
                                '<div class="mx-4">'   +         
                                '<h4 class="font-weight-bold mb-3">' + r[index].destopic +  '</h4>' +
                                '<h6 class="font-weight-bold grey-text mb-3"><a href="' + r[index].idtopic + '"></a></h6>' +
                                '<p class="grey-text">Acompanheo topico clicando no link abaixo.</p><a class="p-2 fa-lg fb-ic">' +
                                '<i class="nc-icon nc-spaceship"></i>' +
                                '</a>' +
                                '</div>' +
                                '</div>';
              }

              
             
              
            
            } catch (error) {
                statusAZ.style.display = "block";
                statusAZ.innerHTML = "Nao foi possivel concluir a busca. Tente novamente.";
              
            }
            
          } else 
          {
            statusAZ.style.display = "block";
            statusAZ.innerHTML = "Nao foi possivel concluir a busca. Tente novamente.";
          }
          
          
  
        }

        
      xhr.open("GET", "https://lds-club-com.umbler.net/data/ajax/AZ?l=" + value, true);
      xhr.send(null);




    }, false); // evento ajax para atualizar.
    
      
  }




}());