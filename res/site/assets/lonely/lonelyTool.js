/* 

LonelyTool V 2.0

l_. By Luca Negrette ._l


*/


const Lonely = (function(){


    if (window.jQuery){
        var $window = $(window);
    
    } else {
        console.log('no jQuery');
    }
    
    return {
    
        addEvent: function(el, event, callback){
            
            if ('addEventListener' in el) {
                el.addEventListener(event, callback, false);
            } else {
                el['e' + event + callback] = callback;
                el[event + callback] = function(){
                    el['e' + event + callback](window.event);
    
                }
                el.attachEvent('on' + event, el[event + callback]);
            }
        },
        removeEvent: function(el, event, callback){
            if ('removeEventListener' in el){
                el.removeEventListener(event, callback, false);
            } else {
                el.detachEvent('on' + event, el[event + callback]);
                el[event + callback] = null;
                el['e' + event + callback] = null;
            }
        },
        copyText: function(el){
            el.select();
            document.execCommand("copy");
        },
        capsLock: function(e, el){
            if (e){
                
                el.style.display =  e.getModifierState("CapsLock") ?  "block" : "none";
            } else {
    
                e = window.event;
                
                el.style.display =  e.getModifierState("CapsLock") ?  "block" : "none";
            }
                   
        },
        autocomplete: function(inp, arr){
            
            if(window.jQuery){
                // alert();
    
            } if ( 4 > 0) {
    
        
            var currentFocus;
            Lonely.addEvent(inp, 'blur', function(){
                this.classList.remove("input-light-search-per-focus");
            });
    
            Lonely.addEvent(inp, 'input', function(e){
                var a, b, i, val = this.value;
               
                if(this.value.length > 0 ){
                    this.classList.add("input-light-search-per-focus");
                } else if (this.value.length === 0) {
                    this.classList.remove("input-light-search-per-focus");
                }
    
                closeAllLists();
    
                if (!val) { return false;}
                
                currentFocus = -1;
    
                a = document.createElement("DIV");
                a.setAttribute("id", this.id + "autocomplete-list-per");
                a.setAttribute("class", "autocomplete-items-per");
                this.parentNode.appendChild(a);
    
    
                for (i = 0; i < arr.length; i++){
    
                    if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()){
                        b = document.createElement("DIV");
                        b.className = "lista";
                        b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                        b.innerHTML += arr[i].substr(val.length);
    
                        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
    
                        Lonely.addEvent(b, "click", function(e){
    
                            inp.value = this.getElementsByTagName("input")[0].value;
                            closeAllLists();
                        });
                        a.appendChild(b);
                    }
    
                }
    
            });
            Lonely.addEvent(inp, "keydown", function(e){
                var x = document.getElementById(this.id + "autocomplete-list-per");
                if (x) x = x.getElementsByTagName("div");
                if (e.keyCode === 40) {
                    currentFocus++;
                    addActive(x);
                } else if (e.keyCode == 38){
                    currentFocus--;
                    addActive(x);
                } else if (e.keyCode === 13){
                    e.preventDefault();
                }
                if (currentFocus > -1) {
                    
                    if (x) x[currentFocus].click();
                }
            });
            function addActive(x){
                if (!x) return false;
                removeActive(x)
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                x[currentFocus].classList.add("autocomplete-active-per");
            }
            function removeActive(x){
                for (var i = 0; i < x.length; i++) {
                    x[i].classList.remove("autocomplete-active-per");
                  }
            }
            function closeAllLists(elmnt){
                var x = document.getElementsByClassName("autocomplete-items-per");
                for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                    x[i].parentNode.removeChild(x[i]);
                    }
                }
            }
            Lonely.addEvent(document, "click", function(e){
                
                e.stopPropagation();
                closeAllLists(e.target);
            });
            
    
          } // else
    
        }, // autocomplete
        form: {
            cache: {},
            validateEmail: function(el, warning){
                var patter = /[^@]+@[^@]+/.test(el.value);
                el = $(el);
                !patter ? warning.html("insert a valide email").siblings(el).removeClass("bd-green-per-1")
                .addClass("bd-red-per-1")
                : warning.html("").siblings(el).removeClass("bd-red-per-1").addClass("bd-green-per-1");
                if (!patter) return false;
                if (patter) return true;
                
                
            },
            validateDate: function(el){
                var patter = /^(\d{2}\/\d{2}\/\d{4})|(\d{4}-\d{2}-\d{2})$/.test(el.value);
            },
            validateNumber: function(el){
                var patter = /^\d+$/.test(el.value); 
            },
            switchMaster: false,
            switchForm: function(){
                for (i in cache){
                    if (!cache[i]){
                        Lonely.form.switchMaster = false;
                        break;
                    }
                    Lonely.form.switchMaster = true;
                }
            },
            
    
        },
        data: {
            
        }
    
        
    
    } // return
    
    }());
    