$(document).ready(function() {
     $('.add-to-cart').on('click', function(e) {


          $.ajaxSetup({
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
          });
          var menu_id = $(this).data("id");
          $.ajax({
               type: 'POST',
               url: "addtocart",
               data: {
                    menu_id: menu_id,
                    addon: true
               },
               dataType: 'json',
               success: function(data) {
                   // console.log(JSON.stringify(data));
                   
                    if(data.status == "error"){
                         tata.error('', data.message)
                    }else if (data.status == "addons") {
                         $("#addon-alert").hide();
                         $('#addon-modal').modal('show');
                         var html =
                              '<input type="hidden"  name="menu_id" value="' +
                              menu_id + '">'
                         var first = ''
                         $.each(data.data, function(index, element) {
                              var j = 0;
                              html +=
                                   '<div class="panel-details panel-details-size"><h5 class="panel-details-title"><!--<label class="custom-control custom-radio"><input name="radio_title_size" type="radio" class="custom-control-input"><span class="custom-control-indicator"></span></label>--><a href="#panel-details-sizes-list' +
                                   element.acatid +
                                   '" data-toggle="collapse"  style="display: block;">' +
                                   element.acategory +
                                   ' <span class="icon icon-sm pull-right"><i class="ti ti-angle-down"></i></span></a></h5><div id="panel-details-sizes-list' +
                                   element.acatid + '" class="collapse ' +
                                   first +
                                   '"><div class="panel-details-content" data-required="' +
                                   element.required +
                                   '"  data-addon="'+ element.acategory +'"><div class="product-modal-sizes">'
                              if (element.multiple) {
                                   $.each(element.aitems, function(
                                        index2, value) {
                                        html +=
                                             '<div class="form-group form-inline"><label class="custom-control custom-checkbox"><input type="checkbox" name="addons[' +
                                             element.acatid +
                                             ']['+j+'][id]" value="' +
                                             value.item_id +
                                             '" class="custom-control-input"  ><span class="custom-control-indicator"><svg class="icon" x="0px" y="0px" viewBox="0 0 32 32"><path stroke-dasharray="19.79 19.79" stroke-dashoffset="19.79" fill="none" stroke="#FFFFFF" stroke-width="4" stroke-linecap="square" stroke-miterlimit="10" d="M9,17l3.9,3.9c0.1,0.1,0.2,0.1,0.3,0L23,11"></path></svg></span><span class="custom-control-description">' +
                                             value.name +
                                             ' - ( £ ' + value
                                             .price +
                                              ')</span></label>';
                                             if((value.max-value.min)>=1)
                                                  html += '<input type="number"   name="addons[' +element.acatid +']['+j+'][qty]" min="'+ value.min +'" max="'+value.max+'" value="'+ value.min +'" step="1" class="p-0"></div>';
                                             else
                                             html += '<input type="text" name="addons[' +element.acatid +']['+j+'][qty]" inputmode="decimal" style="max-width:28px;max-height:26px;background-color: #fff;color: #000;text-align: center;margin-right: 26px;" class="form-control ml-auto p-0" value="'+ value.min +'" readonly=""></div>';
                                             j++;
                                   });
                              } else {
                                   $.each(element.aitems, function(
                                        index2, value) {
                                        html +=
                                             '<div class="form-group form-inline"><label class="custom-control custom-radio"><input name="addons[' +
                                             element.acatid +
                                             '][0][id]"  type="radio"  value="' +
                                             value.item_id +
                                             '"  class="custom-control-input" ><span class="custom-control-indicator"><svg class="icon" x="0px" y="0px" viewBox="0 0 32 32"><path stroke-dasharray="19.79 19.79" stroke-dashoffset="19.79" fill="none" stroke="#FFFFFF" stroke-width="4" stroke-linecap="square" stroke-miterlimit="10" d="M9,17l3.9,3.9c0.1,0.1,0.2,0.1,0.3,0L23,11"></path></svg></span><span class="custom-control-description">' +
                                             value.name +
                                             ' - ( £ ' + value
                                             .price +
                                             ')</span></label>';
                                             if((value.max-value.min)>=1)
                                                  html += '<input type="number"   name="addons[' +element.acatid +']['+j+'][qty]" min="'+ value.min +'" max="'+value.max+'" value="'+ value.min +'" step="1" class="p-0"></div>';
                                             else
                                             html += '<input type="text"  name="addons[' +element.acatid +']['+j+'][qty]"  inputmode="decimal" style="max-width:28px;max-height:26px;background-color: #fff;color: #000;text-align: center;margin-right: 26px;" class="form-control ml-auto p-0" value="'+ value.min +'" readonly=""></div>'; 
                                             j++;  
                                   });
                              }
                              html += '</div></div></div></div>';
                              first = '';
                             
                         });
                         $('#addon-content').html(html);
                         $('#other_info').val('');
                         $('#other-form').show();
                         $("input[type='number']").inputSpinner();// r
                         // $('#addon-model-add-btn').data('id', menu_id);
                    } else {
                         //var html = '<table id="cart-table"><thead><tr><th >Name</th><th>Progress</th><th>Gender</th><th>Height</th><th>Favourite Color</th></tr></thead><tbody><tr>'
                         cartupdate(data.data);
                         tata.success('', 'Item added to cart');
                    }
               }
          })



     })



     $('#addon-form').submit(function(e) {
          e.preventDefault();
          var err = 0;
          // verror[0] = ""; 
          $("#addon-alert").hide();
          $("#addon-alert").empty();
          
          $('.panel-details-content').each(function() {
               if ($(this).data('required')) {
                    var check = 0;
                    $(this).find(':input').each(function() {
                         if ($(this).prop('checked') == true) {
                             check++;
                         }
                        
                    });
                    if(check==0){
                         $("#addon-alert").append('<p class="mb-0">'+$(this).data('addon')+' is required</p>');
                         err++;
                    }
               }


          });
          if(err>0){
               $("#addon-alert").show();
               return false;
          }else{
              
          }
                  



          $.ajaxSetup({
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
          });
          $.ajax({
               type: 'POST',
               url: "addtocart",
               data: $('#addon-form').serialize(),
               dataType: 'json',
               success: function(data) {
                    $('#addon-modal').modal('hide');
                    cartupdate(data.data);
                    tata.success('', 'Item added to cart')
               }
          });

     });

     /*

               $('#add-to-cart-model').on('click', function(e) {
                    $.ajaxSetup({
                         headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                         }
                    });
                    $.ajax({
                         type: 'POST',
                         url: "addtocart",
                         data: $('#addon-form').serialize(),
                         dataType: 'json',
                         success: function(data) {
                              $('#addon-modal').modal('hide');
                              cartupdate(data.data);
                              tata.success('', 'Item Added')
                         }
                    });
               });
     */
     $(document).on('click', '.remove-item', function(event) {
          event.preventDefault();
          $.ajaxSetup({
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
          });
          $.ajax({
               type: 'POST',
               url: "removeitem",
               data: {
                    menu_id: $(this).data("id")
               },
               dataType: 'json',
               success: function(data) {
                    cartupdate(data.data);
                    tata.error('', 'Item Removed From Cart')
               }
          });
     });

     function cartupdate(cart) {
       // console.log(cart);
         // $('#cart-btn').removeClass("bounce");
          //$('#cart-btn').addClass("bounce");
          $('#cart-btn').removeClass("bounce").addClass('bounce').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
               $(this).removeClass("bounce");
             });

          var html = '';
          var total_price = 0;
          var total_qty = 0;
          $.each(cart.items, function(key, item) {
               html += '<tr><td>' + item.name +
                    '</td><td>' + item.quantity +
                    '</td><td>£&nbsp;' + item.price +
                    '</td><td class="actions"><!--<a href="#product-modal" data-toggle="modal" class="action-icon"><i class="ti ti-pencil"></i></a>--> <a href="#" class="action-icon remove-item" data-id="' +
                    key + '"><i class="ti ti-close"></i></a>  </td></tr>';
               
                    $.each(item.addons, function(k, addon) {
                         html += '<tr><td colspan="2" class="text-right"  style="line-height: .25;">' + addon.name +
                                  '</td><td class="p-0 text-center"  style="line-height: .25;">' + addon.qty +
                         '</td><td class="p-0 text-left"  style="line-height: .25;" >£&nbsp;' + addon.price +' </td></tr>';
                         total_price += parseFloat(addon.price)*parseInt(addon.qty);
                    });

               total_price += parseInt(item.quantity) * parseFloat(item.price);
               total_qty += parseInt(item.quantity);
          })
          $('.cart-table').html(html);
          $('.cart-products-total').html(total_price.toFixed(2));
          $('.cart-total').html(total_price.toFixed(2));
          $('.notification').html(total_qty);
          if (total_qty > 0){
               $('.cart-empty').hide();
               $("#checkout-btn").removeClass('disabled');
          }else{
               $('.cart-empty').show();
             
               $("#checkout-btn").addClass('disabled');
          }
               


     }
     //page load update cart
     //$('.notification').html({{$total_qty}});

     /*----  Search -------------*/
     var searchTerm, panelContainer, txtValue, veg;

     $('#search-food').on('change keyup paste', function() {
          searchTerm = $(this).val();
          if (searchTerm != "") {
               veg = $('#veg-only').is(':checked');
               $('.menu-category-title').hide();
               $('.menu-category').each(function() {
                    panelContainer = 'menuContent' + $(this).data('id');
                    $('#' + panelContainer + ' > .menu-item').each(function() {
                         //console.log(veg);
                         //console.log($(this).data('veg'));
                         //if(veg && (typeof  $(this).data('veg') ==="undefined")
                             // return;
                         txtValue = $(this).text();
                         if (txtValue.toUpperCase().indexOf(searchTerm
                                   .toUpperCase()) > -1) {

                              $(this).show();
                              $('#' + panelContainer).addClass('show');
                              
                         } else {
                              $(this).hide();
                              $('#' + panelContainer).removeClass('show');
                         }
                    });
               });
          } else {
               $('.menu-category-title').show();
               $('.menu-item').show();
               $('.menu-category-content').removeClass('show');
          }
     });


     $('#veg-only').on('click', function() {
          if ($(this).prop("checked") == true) {
               $('.menu-category').each(function() {
                    var catId = $(this).data('id');
                    panelContainer = 'menuContent' + $(this).data('id');
                    var count = 0;
                    $('#' + panelContainer + ' > .menu-item').each(function() {
                         if (!$(this).data('veg')) {
                              $(this).hide();
                         } else {
                              count++;
                         }
                    });
                    if (count == 0)
                         $('#menu-category' + catId).hide();

               });
          } else {
               $('.menu-item').show();
               $('.menu-category').show();
          }

     });



     function ukpostcodevalidate(errordiv, txt_postcode) {
          if (errordiv != "") document.getElementById(errordiv).innerHTML = "";
          var teststring = document.getElementById(txt_postcode).value;
          var testfalsepass = document.getElementById(txt_postcode).value;
          test = teststring.replace(/ /g, "");
          teststringsize = test.length;
          lastpart = test.substring(teststringsize - 3, teststringsize);
          firstpart = test.substring(0, teststringsize - 3);
          test = firstpart + " " + lastpart;
          size = test.length;
          test = test.toUpperCase();
          while (test.slice(0, 1) == " ") {
              test =
                  test.substr(1, size - 1);
              size = test.length
          }
          while (test.slice(size - 1, size) == " ") {
              test = test.substr(0, size - 1);
              size = test.length
          }
          document.getElementById(txt_postcode).value = test;
          if (size < 6 || size > 8) {
              if (errordiv != "") document.getElementById(errordiv).innerHTML =" please check postcode and try again";
              document.getElementById(txt_postcode).value = testfalsepass;
              document.getElementById(txt_postcode).focus();
              return false
          }
          if (!isNaN(test.charAt(0))) {
              if (errordiv != "") document.getElementById(errordiv).innerHTML = " invalid postcode";
              document.getElementById(txt_postcode).value = testfalsepass;
              document.getElementById(txt_postcode).focus();
              return false
          }
          if (isNaN(test.charAt(size - 3))) {
              if (errordiv != "") document.getElementById(errordiv).innerHTML =  " invalid postcode";
              document.getElementById(txt_postcode).value = testfalsepass;
              document.getElementById(txt_postcode).focus();
              return false
          }
          if (!isNaN(test.charAt(size - 2))) {
              if (errordiv != "") document.getElementById(errordiv).innerHTML = " invalid postcode";
              document.getElementById(txt_postcode).value =
                  testfalsepass;
              document.getElementById(txt_postcode).focus();
              return false
          }
          if (!isNaN(test.charAt(size - 1))) {
              if (errordiv != "") document.getElementById(errordiv).innerHTML = " invalid postcode";
              document.getElementById(txt_postcode).value = testfalsepass;
              document.getElementById(txt_postcode).focus();
              return false
          }
          if (!(test.charAt(size - 4) == " ")) {
              if (errordiv != "") document.getElementById(errordiv).innerHTML =  " invalid postcode, please ensure you enter a space correctly";
              document.getElementById(txt_postcode).value =  testfalsepass;
              document.getElementById(txt_postcode).focus();
              return false
          }
          count1 = test.indexOf(" ");
          count2 = test.lastIndexOf(" ");
          if (count1 != count2) {
              if (errordiv != "") document.getElementById(errordiv).innerHTML = test + " invalid postcode - too many spaces";
              document.getElementById(txt_postcode).value = testfalsepass;
              document.getElementById(txt_postcode).focus();
              return false
          }
          return true
      };
      
      function calcRoute() {
          var postcode = $('#userpostcode').val();   
          $.ajaxSetup({
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
          });   
          $.ajax({
               type: 'GET',
               url: 'calcdistance',
               data: { postcode: postcode},
               success: function (data) {
                    if(data.status=="success"){
                         $('#order-type').modal('hide'); 
                    }else{
                         $('#postcodeerr').html(data.message);
                    }

          
               },
               error: function (data) {
               alert("Error occured.please try again");
               },
               dataType: 'json'
          });
          
     }
          
          

     $('#proceed-btn').on('click', function(e) {
          if (localStorage) {
               localStorage.setItem("ordertype", $(
                    'input[name="ordertype"]:checked').val());
          }
          if($('input[name="ordertype"]:checked').val()=="delivery"){
               if(ukpostcodevalidate("postcodeerr","userpostcode")){
                    calcRoute();
               }else{

               }                     
          }else{
               $('#order-type').modal('hide'); 
          }


     });
  $('#userpostcode').on('blur', function() {

    if(ukpostcodevalidate("postcodeerr","userpostcode")){
          calcRoute();
          $.ajax({
               type: 'GET',
               url: "deliveryfee",
               data: { postcode:  $('#userpostcode').val()  },
               dataType: 'json',
               success: function(data) {
                    $('#delivery-charge').html(data.fee);
                    $('#amount-to-pay').html( parseFloat($('#order-total').text())-parseFloat($('#discount-deli').text())+ parseFloat($('#delivery-charge').text()));
                   // $('.cart-total').html( parseFloat($('.cart-total').text())+parseFloat(data.fee));
                   // cartupdate(data.data);
                  //  tata.error('', 'Item Removed From Cart')
               }
          });
     } 
    
  });




     $('#showcart,#cartclose,#showcartmob,#cart-icon').on('click', function(e) {
          e.preventDefault();
          $('#panel-cart').toggleClass('show');
     });


     $('#delivery').on('click', function(e) {
          $('#delivery-details').collapse('show')
     });
     $('#collection').on('click', function(e) {
          $('#delivery-details').collapse('hide')
     });

     if (localStorage.getItem("ordertype") === null) {
          $('#order-type').modal('show');
     }
    // $('#order-type').modal('show'); // r

     var prevValue = "";
     $(document.body).on("click", "#addon-modal input:radio", function() {
          var rvalue = $(this).val();
          if (prevValue == rvalue) {
               $(this).prop('checked', false);
               prevValue = "";
          } else {
               prevValue = rvalue;
          }
     });

     $('#checkout-order-type').on('change', function() {

          if ($(this).find('option:selected').val() == "collection") {
               $('.for-delivery').hide();
               $('.for-collection').show();
               localStorage.setItem("ordertype", "collection");
               $('#amount-to-pay').html( parseFloat($('#order-total').text())-parseFloat($('#discount-coll').text()));
          } else if ($(this).find('option:selected').val() == "delivery") {
               $('.for-delivery').show();
               $('.for-collection').hide();
               $('#amount-to-pay').html( parseFloat($('#order-total').text())-parseFloat($('#discount-deli').text())+ parseFloat($('#delivery-charge').text()));
               localStorage.setItem("ordertype", "delivery");
               
               $.ajax({
                    type: 'GET',
                    url: "deliveryfee",
                    data: { postcode:  $('#userpostcode').val()  },
                    dataType: 'json',
                    success: function(data) {
                         $('#delivery-charge').html(data.fee);
                         $('#amount-to-pay').html( parseFloat($('#order-total').text())-parseFloat($('#discount-deli').text())+ parseFloat($('#delivery-charge').text()));

                        // $('.cart-total').html( parseFloat($('.cart-total').text())+parseFloat(data.fee));
                        // cartupdate(data.data);
                       //  tata.error('', 'Item Removed From Cart')
                    }
               });
               
              
          } else {
               localStorage.removeItem("ordertype");
          }

         

     });
     if (localStorage) {
          if (localStorage.getItem("ordertype") === null) {
               $('#checkout-order-type option[value=]').attr('selected', 'selected');
               $('.for-delivery').hide();
               $('.for-collection').hide();
          } else if (localStorage.getItem("ordertype") == "collection") {
               $('#checkout-order-type option[value=collection]').attr('selected', 'selected');
               $('.for-delivery').hide();
               $('#amount-to-pay').html( parseFloat($('#order-total').text())-parseFloat($('#discount-coll').text()));
          } else {
               $('#checkout-order-type option[value=delivery]').attr('selected', 'selected');
               $('.for-collection').hide();

               $.ajax({
                    type: 'GET',
                    url: "deliveryfee",
                    data: { postcode:  $('#userpostcode').val()  },
                    dataType: 'json',
                    success: function(data) {
                         $('#delivery-charge').html(data.fee);
                         $('#amount-to-pay').html( parseFloat($('#order-total').text())-parseFloat($('#discount-deli').text())+ parseFloat($('#delivery-charge').text()));
                        // $('.cart-total').html( parseFloat($('.cart-total').text())+parseFloat(data.fee));
                        // cartupdate(data.data);
                       //  tata.error('', 'Item Removed From Cart')
                    }
               });

              // $('#amount-to-pay').html( parseFloat($('#order-total').text())-parseFloat($('#discount-deli').text())+ parseFloat($('#delivery-charge').text()));
          }

     }
    

 
     $(window).scroll(function() {
          if ($(window).scrollTop() >= 100) {
               $('#cart-btn').show("slide");
          } else {
               $('#cart-btn').hide("slide");
          }
     });
     if ($(window).scrollTop() >= 100) {
          $("#cart-btn").show("slide");

     }
    function open_modal(){
		    $('#order-type').modal('show'); 
	}











});