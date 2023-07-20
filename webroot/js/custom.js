var base_url2 = 'http://localhost:8888/';
var base_url = 'http://localhost:8888/rabbit_pro/app/';

//********************* Create User *************************
 $(document).ready(function() {
    $("#submitSignupForm_Btn").click(function(){
      var name = $('#name').val();
      var email = $('#email').val();
      var phone_no = $('#phone_no').val();
      var password = $('#password').val();
      var cpass = $('#cpass').val();
      var tnc = $('#tnc').val();
      //console.log(tnc)

      if(name == ''){
        alert('Please enter name');
        return;
      }

      if(!isEmail(email)){
        alert('Please enter a valid email address');
        return;
      }

      if(phone_no == ''){
        alert('Please enter valid phone number');
        return;
      }

      if(password == ''){
        alert('Please enter password');
        return;
      }

      if(cpass == ''){
        alert('Please confirm password');
        return;
      }

      if(password != cpass){
        alert('Password does not match');
        return;
      }

      if(tnc != '1'){
        alert('Please accept Terms and Conditions');
        return;
      }


      
      var formData = getFormObj('signupForm');
      var url = $("#signupForm").attr("action");
      blockUI()
      //console.log(formData);
      $.ajaxSetup({
           headers:{
              'Api-Key': "CDFGT1254#*35HY!@ofr014"
           }
      });

      $.post(url,
        formData,
        function(data, textStatus, jqXHR){
           console.log(data); 
           //console.log(data.User.status); 
           $.unblockUI();
           if(data.User.status_id == 1){
            $('#signup_success_alert').html(data.User.description).show()
            setTimeout(function(){ window.location = '../users/login'; }, 5000);
            //window.location.href = '../users/login';
           }
           else{
                $('#signup_error_alert').html(data.User.description).show()
           }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            $.unblockUI();
          console.log(errorThrown);
          $('#signup_error_alert').html(errorThrown).show()
          //$('#loader').hide(); 
          //location.reload();
        });
      });

  });





 //********************* Password Reset *************************
 $(document).ready(function() {
    $("#resetPassword_Btn").click(function(){
      var email = $('#email').val();
      //console.log(tnc)

      if(!isEmail(email)){
        alert('Please enter a valid email address');
        return;
      }

      
      var formData = getFormObj('passwordRequestForm');
      var url = $("#passwordRequestForm").attr("action");
      blockUI()
      //console.log(formData);
      $.ajaxSetup({
           headers:{
              'Api-Key': "CDFGT1254#*35HY!@ofr014"
           }
      });

      $.post(url,
        formData,
        function(data, textStatus, jqXHR){
           console.log(data); 
           //console.log(data.User); 
           $.unblockUI();
           $('#email').val('')
           if(data.User.status_id == 1){
            $('#password_reset_success_alert').html(data.User.description).show()
           }
           else{
                $('#password_reset_error_alert').html(data.User.description).show()
           }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            $('#email').val('')
            $.unblockUI();
          console.log(errorThrown);
          $('#password_reset_error_alert').html(errorThrown).show()
          //$('#loader').hide(); 
          //location.reload();
        });
      });

  });



 //********************* Create new breeder *************************
 /*$(document).ready(function() {
    $("#newBreederSubmit_Btn").click(function(){
        //console.log("Hi")
      var name = $('#name').val();
      var sex = $('#sex_id').val();
      //console.log(tnc)

      if(name == ''){
        alert('Please enter name');
        return;
      }

      if(sex == ''){
        alert('Please select sex');
        return;
      }
      
      var formData = getFormObj('newBreederForm');
      var url = $("#newBreederForm").attr("action");
      blockUI()
      //console.log(formData);
      $.ajaxSetup({
           headers:{
              'Api-Key': "CDFGT1254#*35HY!@ofr014"
           }
      });

      $.post(url,
        formData,
        function(data, textStatus, jqXHR){
           console.log(data); 
           //console.log(data.User.status); 
           $.unblockUI();
           location.reload();
        }).fail(function(jqXHR, textStatus, errorThrown) {
            $.unblockUI();
            console.log(errorThrown);
            //$('#signup_error_alert').html(errorThrown).show()
          //$('#loader').hide(); 
          //location.reload();
        });
      });

  });*/



 //********************* Edit breeder *************************
 $(document).ready(function() {
    $("#editBreederSubmit_Btn").click(function(){
        //console.log("Hi")
      var name = $('#editBreeder_name').val();
      var sex = $('#editBreeder_sex_id').val();
      //console.log(tnc)

      if(name == ''){
        alert('Please enter name');
        return;
      }

      if(sex == ''){
        alert('Please select sex');
        return;
      }
      
      var formData = getFormObj('editBreederForm');
      var url = $("#editBreederForm").attr("action");
      blockUI()
      //console.log(formData);
      $.post(url,
        formData,
        function(data, textStatus, jqXHR){
           console.log(data); 
           //console.log(data.User.status); 
           $.unblockUI();
           location.reload();
        }).fail(function(jqXHR, textStatus, errorThrown) {
            $.unblockUI();
            console.log(errorThrown);
            //$('#signup_error_alert').html(errorThrown).show()
          //$('#loader').hide(); 
          //location.reload();
        });
      });

  });



//********************* Edit Package Item *************************
 function editPackageItem(id){
    var url = base_url2+'rabbit_pro/app/api/getPackageItem/'+id;
    console.log(id)
    $.ajaxSetup({
        headers:{
            'Api-Key': "CDFGT1254#*35HY!@ofr014"
        }
    });

    $.get(url,
        function(data, textStatus, jqXHR){
            console.log(data); 
            var selected_id = data.package_id - 1;
            var optionObject = document.getElementById('editPackageItem_package_id');
            optionObject.options[selected_id].selected = true;
            $('#select2-editPackageItem_package_id-container').html(data.package_name);

           $('#editPackageItem_id').val(data.id)
           $('#editPackageItem_name').val(data.name)
           $('#editPackageItem_quantity').val(data.quantity)
           //console.log(data.User.status); 
        }).fail(function(jqXHR, textStatus, errorThrown) {
            $.unblockUI();
            console.log(errorThrown);
        });
 }




 //********************* Edit Birth Form *************************
 function editBirth(id){
    var url = base_url+'births/getBirthDetails/'+id;
    //console.log(url); 
    $.get(url,
        function(data, textStatus, jqXHR){
            //console.log(data.plan_id); 
            if(data.plan_id != null){
                var selected_id = data.plan_id;
                //console.log(selected_id); 
                var optionObject = document.getElementById('birth_form_plan_id');
                optionObject.options[selected_id].selected = true;
            }

            $('#select2-birth_form_plan_id-container').html(data.plan_name);

           $('#birth_form_id').val(data.id)
           $('#birth_form_litter_id').val(data.litter_id)
           $('#birth_form_no_live_kits').val(data.no_live_kits)
           $('#birth_form_no_dead_kits').val(data.no_dead_kits)
           $('#birth_form_no_kits').val(data.no_kits)
           $('#birth_form_cage').val(data.cage)
           $('#birth_form_date_born').val(data.date_born)
           $('#birth_form_date_bred').val(data.date_bred)
           //console.log(data.User.status); 
        }).fail(function(jqXHR, textStatus, errorThrown) {
            $.unblockUI();
            console.log(errorThrown);
        });
 }




 //********************* Get Breeder Detail *************************
 function getBreederDetail(id){
    var url = base_url+'breeders/getBreederDetails_web/'+id;
    console.log(id)
    
    $.get(url,
        function(data, textStatus, jqXHR){
            console.log(data); 
            /*var selected_id = data.package_id - 1;
            var optionObject = document.getElementById('editPackageItem_package_id');
            optionObject.options[selected_id].selected = true;
            $('#select2-editPackageItem_package_id-container').html(data.package_name);*/

            $('#select2-editBreeder_breed_id-container').html(data.breed_name);
            $('#select2-editBreeder_sex_id-container').html(data.sex_name);
            $('#select2-editBreeder_father-container').html(data.father_name);
            $('#select2-editBreeder_mother-container').html(data.mother_name);

           $('#editBreeder_id').val(data.id)
           $('#editBreeder_name').val(data.name)
           $('#editBreeder_breeder_id').val(data.breeder_id)
           $('#editBreeder_breed_id').val(data.breed_id)
           $('#editBreeder_date_born').val(data.date_born)
           $('#editBreeder_father').val(data.father)
           $('#editBreeder_cage').val(data.cage)
           $('#editBreeder_color').val(data.color)
           $('#editBreeder_sex_id').val(data.sex_id)
           $('#editBreeder_date_acquired').val(data.date_acquired)
           $('#editBreeder_mother').val(data.mother)
           //console.log(data.User.status); 
        }).fail(function(jqXHR, textStatus, errorThrown) {
            $.unblockUI();
            console.log(errorThrown);
        });
 }



//********************* Get Task Dates *************************
function getTaskDates(type){
    if(type == 'add'){
        var breeding_date = $('#mew_breed_model_date').val()
    }
    else if(type == 'edit'){
        var breeding_date = $('#edit_breed_model_date').val()
    }
    var date = new Date(breeding_date);

    var formate_breeding_date = breeding_date.split('-')
    var breeding_date2 = formate_breeding_date[2]+'/'+formate_breeding_date[1]+'/'+formate_breeding_date[0];

    var newdate = new Date(date);
    newdate.setDate(newdate.getDate() + 14); //Pregnancy check
    var dd = newdate.getDate();
    var mm = newdate.getMonth() + 1;
    var y = newdate.getFullYear();
    var pregnancy_check_date = dd + '/' + mm + '/' + y;

    var nestboxdate = new Date(date);
    nestboxdate.setDate(nestboxdate.getDate() + 28); //Nest box
    var dd = nestboxdate.getDate();
    var mm = nestboxdate.getMonth() + 1;
    var y = nestboxdate.getFullYear();
    var nest_box_date = dd + '/' + mm + '/' + y;

    var kindledate = new Date(date);
    kindledate.setDate(kindledate.getDate() + 30); //Kindle
    var dd = kindledate.getDate();
    var mm = kindledate.getMonth() + 1;
    var y = kindledate.getFullYear();
    var kindle_date = dd + '/' + mm + '/' + y;

    var kindle_date2 = y + '-' + mm + '-' + dd;
    var date = new Date(kindle_date2);
    var weandate = new Date(date);
    weandate.setDate(weandate.getDate() + 35); //Wean
    var dd = weandate.getDate();
    var mm = weandate.getMonth() + 1;
    var y = weandate.getFullYear();
    var wean_date = dd + '/' + mm + '/' + y;

    
    console.log(breeding_date2)
    if(type == 'add'){
        $('#new_breed_model_task_date_1').html(breeding_date2)
        $('#new_breed_model_task_date_2').html(pregnancy_check_date)
        $('#new_breed_model_task_date_3').html(nest_box_date)
        $('#new_breed_model_task_date_4').html(kindle_date)
        $('#new_breed_model_task_date_9').html(wean_date)
    }
    else if(type == 'edit'){
        $('#edit_breed_model_task_date_1').html(breeding_date2)
        $('#edit_breed_model_task_date_2').html(pregnancy_check_date)
        $('#edit_breed_model_task_date_3').html(nest_box_date)
        $('#edit_breed_model_task_date_4').html(kindle_date)
        $('#edit_breed_model_task_date_9').html(wean_date)
    }
}




function getTaskDatesByPlan(plan_id){
    
    var url = base_url+'schedules/getSchedules/'+plan_id;
    console.log(plan_id)
    
    $.get(url,
        function(data, textStatus, jqXHR){
            console.log(data); 
            var i=0;
            var mod = 0;
            var color = '';
            var html = '';
            data.forEach(function(item){
              //console.log('ID: ' + item.id);
              mod = i%2;
              if(mod == 0){
                color = 'bg-warning';
              }
              else{
                color = 'bg-primary';
              }
              html = '<li class="list-group-item">'+
                        '<div class="todo-indicator '+color+'"></div>'+
                            '<div class="widget-content p-0">'+
                                '<div class="widget-content-wrapper">'+
                                    '<div class="widget-content-left mr-2"></div>'+
                                        '<div class="widget-content-left">'+
                                            '<div class="widget-heading">'+item.name+'</div>'+
                                                '<div class="widget-subheading"><i>'+item.date+'</i></div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                       '</li>';

                i++;

                $('#task_list').append(html);
            });
            
        }).fail(function(jqXHR, textStatus, errorThrown) {
            $.unblockUI();
            console.log(errorThrown);
        });
    
}





  function getFormObj(formId) {
    var formObj = {};
    var inputs = $('#'+formId).serializeArray();
    $.each(inputs, function (i, input) {
        formObj[input.name] = input.value;
    });
    return formObj;
  }


  function blockUI(){
    $.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } }); 
    return;
  }



  function getRabbitNameAndSex(id){
    var url = base_url+'breeders/getBreederName/'+id;
    console.log(id)
    
    $.get(url,
        function(data, textStatus, jqXHR){
            console.log(data); 
            if(data.sex_id == 2){
                $('#select2-buck-container').html(data.name);
                $('#select2-doe-container').html('');
            }
            else if(data.sex_id == 1){
                $('#select2-doe-container').html(data.name);
                $('#select2-buck-container').html('');
            }
            
        }).fail(function(jqXHR, textStatus, errorThrown) {
            $.unblockUI();
            console.log(errorThrown);
        });
  }



  function getBreedPlanForEdit(id){
    var url = base_url+'schedules/getItemToBeEdited/'+id;
    console.log(id)
    
    $.get(url,
        function(data, textStatus, jqXHR){
            console.log(data); 

                $('#edit_breed_buck').val(data.buck);
                $('#edit_breed_doe').val(data.doe);

                $('#select2-edit_breed_buck-container').html(data.buck_name);
                $('#select2-edit_breed_doe-container').html(data.doe_name);
                $('#edit_breed_model_date').val(data.date);
                $('#edit_breed_model_id').val(id);
            
        }).fail(function(jqXHR, textStatus, errorThrown) {
            $.unblockUI();
            console.log(errorThrown);
        });
  }



  function getTaskForEdit(id){
    var url = base_url+'tasks/getTaskDetail/'+id;
    console.log(id)
    
    $.get(url,
        function(data, textStatus, jqXHR){
            data.forEach(function(item){
                console.log(item); 

                $('#editTask_name').val(item.name);
                $('#editTask_schedule_type_id').val(item.schedule_type_id);

                $('#select2-editTask_schedule_type_id-container').html(item.schedule_type);
                $('#editTask_date').val(item.date);
                $('#editTask_id').val(id);
            });
            
        }).fail(function(jqXHR, textStatus, errorThrown) {
            $.unblockUI();
            console.log(errorThrown);
        });
  }



  function getLedgerForEdit(id){
    var url = base_url+'ledgers/getLedgerDetail/'+id;
    console.log(id)
    
    $.get(url,
        function(data, textStatus, jqXHR){
            data.forEach(function(item){
                console.log(item); 

                $('#edit_ledger_date').val(item.date);

                $('#select2-edit_ledger_type-container').html(item.ledger_type_name);
                $('#edit_ledger_type').val(item.ledger_type_id);

                $('#select2-edit_ledger_cat_id-container').html(item.cat_name);
                $('#edit_ledger_cat_id').val(item.cat_id);

                $('#edit_ledger_amount').val(item.amount);
                $('#select2-edit_ledger_breeder_id-container').html(item.breeder_name);
                $('#edit_ledger_breeder_id').val(item.breeder_id);

                if(item.cat_id == 2){
                    $('#edit_ledger_litters_div').hide()
                    $('#edit_ledger_name_div').hide()
                }
                else if(item.cat_id == 3){
                    $('#edit_ledger_breeders_div').hide()
                    $('#edit_ledger_name_div').hide()
                }
                else if(item.cat_id == 1 || item.cat_id == 4){
                    $('#edit_ledger_breeders_div').hide()
                    $('#edit_ledger_litters_div').hide()
                    $('#edit_ledger_status_id_div').hide()
                }

                $('#select2-edit_ledger_litter_id-container').val(item.litter_name);
                $('#edit_ledger_litter_id').val(item.litter_id);

               /* $('#select2-edit_ledger_status_id-container').html(item.amount);
                $('#edit_ledger_status_id').val(item.status_id);*/

                $('#edit_ledger_name').val(item.name);
                $('#edit_ledger_id').val(id);
            });
            
        }).fail(function(jqXHR, textStatus, errorThrown) {
            $.unblockUI();
            console.log(errorThrown);
        });
  }



  function setBreederIdOnSellForm(breeder_id,status_id){
    $('#sellBreeder_breeder_id').val(breeder_id)
    $('#sellBreeder_status_id').val(status_id)
    if(status_id == 4){
        $('#sellModalLabel').html('Sell Breeder')
    }
    else if(status_id == 5){
        $('#sellModalLabel').html('Butcher Breeder')
    }
  }



  function setIdForDeadBreederForm(id){
    $('#deadBreederForm_id').val(id)
  }



  function setBreederIdForWeight(id){
    console.log(id)
    $('#weight_model_breeder_id').val(id)
  }



function categoryClicked(cat_id){
    console.log(cat_id)
    if(cat_id == 1 || cat_id == 4){
        $('#new_ledger_name_div').show()
        $('#new_ledger_litters_div').hide()
        $('#new_ledger_breeders_div').hide()
        $('#new_ledger_status_id_div').hide()

        $('#edit_ledger_name_div').show()
        $('#edit_ledger_litters_div').hide()
        $('#edit_ledger_breeders_div').hide()
        $('#edit_ledger_status_id_div').hide()
    }
    else if(cat_id == 2){
        $('#new_ledger_name_div').hide()
        $('#new_ledger_litters_div').hide()
        $('#new_ledger_breeders_div').show()
        $('#new_ledger_status_id_div').show()

        $('#edit_ledger_name_div').hide()
        $('#edit_ledger_litters_div').hide()
        $('#edit_ledger_breeders_div').show()
        $('#edit_ledger_status_id_div').show()
    }
    else if(cat_id == 3){
        $('#new_ledger_name_div').hide()
        $('#new_ledger_litters_div').show()
        $('#new_ledger_breeders_div').hide()
        $('#new_ledger_status_id_div').show()

        $('#edit_ledger_name_div').hide()
        $('#edit_ledger_litters_div').show()
        $('#edit_ledger_breeders_div').hide()
        $('#edit_ledger_status_id_div').show()
    }
}


function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}

function isEmpty(val){
    //console.log(val);
    var result = '';
     if(val === 'undefined' || val == 'null' || val.length <= 0){
        result = true;
     }
     else{
        result = false;
     }
     return result;
}



