//code for risk modal
//=============================================================

//code for Company
//============================================================

$(document).ready(function(){
    $(document).on('click','.editcompany', function(e){
        e.preventDefault();
        var companyid=$(this).attr("id");
        $.ajax({
            url:'editcompany.php',
            method:'POST',
            data:{companyid:companyid},
            dataType:"json",
            success:function(data){
                $("#companyid").val(data.id);
                $("#cuname").val(data.company_name);
                $("#cugroup").val(data.cgroup);
                $("#cuemail").val(data.email);
                $("#cuphone").val(data.phone);
                $("#cuwebsite").val(data.website);
                $("#cuaddress").val(data.address);
                $("#editcompany-modal").modal('show');
            },
        });
    });
});

$(document).on('click','.updatecompanybtn',function(e){
    e.preventDefault();
    $.ajax({
        url:'companyupdate.php',
        method:'POST',
        data:$('#companyupdateform').serialize(),
        dataType:'json',
        success:function(r){
             Swal.fire({
                 icon: r.status === 'ok' ? 'success' : 'error',
                 title: r.message,
                 timer: 1500
             })
             window.setTimeout(function() {
                 window.location.href = 'bussinf.php';
             }, 1500);
        }

    });
});////end of update

//code for Entity/Departments
//==============================================================


/*$(document).on('click','.addentitybtn', function(e){
        e.preventDefault();
$("#addentity-modal").modal('show');
$(document).on('click','.addentity', function(e){
    e.preventDefault();
        $.ajax({
            url:'addentity.php',
            method:'post',
            data:$("#entityform").serialize(),
            dataType:'text',
            success: function(response){
                Swal.fire({
                    icon: "success",
                    title: response,
                    timer: 1500
                })
                window.setTimeout(function() {
                    window.location.href = 'bussinf.php';
                }, 1500);

            }
        });
});
}); */
function checkentname() {
    var entityname = $('#entityname').val();
    if (entityname == "") {
        $('#entity_err').html('required field');
        return false;
    } else {
        $('#entity_err').html('');
        return true;
    }
}
function checkcompany() {
    var company = $('#entcomp').val();
    if (company == "") {
        $('#company_err').html('required field');
        return false;
    } else {
        $('#company_err').html('');
        return true;
    }
}
function checkowner() {
    var owner = $('#entowner').val();
    if (owner == "") {
        $('#owner_err').html('required field');
        return false;
    } else {
        $('#owner_err').html('');
        return true;
    }
}



//update entity
$(document).on('click','.editentity', function(e){
    e.preventDefault();
    var deptid=$(this).attr("id");
    $.ajax({
        url:'departmentedit.php',
        method:'post',
        data:{deptid:deptid},
        dataType:"json",
        success:function(data){
            $("#eid").val(data.dept_id)
            $("#ename").val(data.dept_name);
            $("#company").val(data.company);
            $("#owner").val(data.owner);
            $("#function").val(data.function);

            $('#editdept-modal').modal('show');
        },
        error: function(xhr, status, error) {
        var err = eval("(" + xhr.responseText + ")");
        alert(err.Message);
        },
    });
 });
 $(document).on('click','.deptupdate', function(e){
     e.preventDefault();
     $.ajax({
         url:'departmentupdate.php',
         method:'post',
         data:$('#deptupdate').serialize(),
         dataType:'json',
         success:function(r){
             Swal.fire({
             icon: r.status === 'ok' ? 'success' : 'error',
             title: r.message,
             timer: 1500
             })
             window.setTimeout(function() {
                 window.location.href = 'bussinf.php';
             }, 1500);
         }

     });

 });
 //delete entity
 $(document).on('click','.delete-dept', function(e){
    e.preventDefault();
    var deptid=$(this).attr("id");
    $.ajax({
       url:'departmentedit.php',
       method:'post',
       data:{deptid:deptid},
       dataType:"json",
       success:function(data){
           $("#entityid").val(data.dept_id);
           $("#entname").html(data.dept_name);

           $('#deptdelete-modal').modal('show');
       }

    });

});
$(document).on('click','.delete-btn', function(e){
e.preventDefault()
$.ajax({
    url:'departmentdelete.php',
    method:'post',
    data:$("#entitydeleteform").serialize(),
    dataType:'json',
    success:function(r){
        Swal.fire({
            icon: r.status === 'ok' ? 'success' : 'error',
            title: r.message,
            timer: 1100
            })
            window.setTimeout(function() {
                window.location.href = 'bussinf.php';
            }, 1100);

    }
});

});
//code for process
//============================================================

// open modal only — submit handler is registered once below
$(document).on('click','.addprocessmodal', function(e){
    e.preventDefault();
    $("#addprocess-modal").modal('show');
});

$('#pentity').on('change', function () {
    checkpentity();
});
$('#processname').on('input', function () {
    checkprocess();
});

$(document).on('click','.addprocess', function(e){
    e.preventDefault();

    if(!checkpentity() && !checkprocess()){
        console.log("er1");
        $("#processmessage").html(`<div class="alert alert-warning">Please fill all required field</div>`);
       }else if( !checkpentity() || !checkprocess()) {
        $("#processmessage").html(`<div class="alert alert-warning">Please fill all required field</div>`);
        console.log("er");
       }else{
            $.ajax({
                url:'processAction.php',
                method:'post',
                data:$("#processform").serialize(),
                dataType:'json',
                success:function(r){
                    Swal.fire({
                        icon: r.status === 'ok' ? 'success' : 'error',
                        title: r.message,
                        timer: 600
                    })
                    window.setTimeout(function() {
                        window.location.href = 'bussinf.php';
                    }, 600);

                },


            });
       }

});

function checkpentity() {
    var pentity = $('#pentity').val();
    if (pentity == "") {
        $('#pentity_err').html('required field');
        return false;
    } else {
        $('#pentity_err').html('');
        return true;
    }
}
function checkprocess() {
    var process = $('#processname').val();
    if (process == "") {
        $('#process_err').html('required field');
        return false;
    } else {
        $('#process_err').html('');
        return true;
    }
}
//edit of process======
    $(document).on('click','.editprocess', function(e){
        e.preventDefault();
        var processid=$(this).attr("id");
        $.ajax({
            url:'processedit.php',
            method:'POST',
            data:{processid:processid},
            dataType:"json",
            success:function(data){
                $("#pid").val(data.process_id);
                $("#entityprocess").val(data.dept_id);
                $("#pname").val(data.process_name);
                $("#detail").val(data.details);

                $("#editprocess-modal").modal('show');
            },
    });
});
//update Process===================

$(document).on('click','.updateprocess', function(e){
    e.preventDefault();
    $.ajax({
        url:'processupdate.php',
        method:'POST',
        data:$('#formprocessupdate').serialize(),
        dataType:'json',
        success:function(r){
             Swal.fire({
                 icon: r.status === 'ok' ? 'success' : 'error',
                 title: r.message,
                 timer: 1500
             })
             window.setTimeout(function() {
                 window.location.href = 'bussinf.php';
             }, 1500);
        }

    });
});

//delete process
$(document).on('click','.processdelete', function(e){
    e.preventDefault();
     var processid=$(this).attr("id");
     $.ajax({
           url:'processedit.php',
           method:'POST',
           data:{processid:processid},
           dataType:"json",
           success:function(data){
               $("#pdid").val(data.process_id);
               $("#pdname").html(data.process_name);
               $("#deleteprocess-modal").modal('show');
           },

     });

   });

   $(document).on('click','.deleteprocess-btn', function(e){
    e.preventDefault();
       $.ajax({
           url:'processdelete.php',
           method:'POST',
           data:$('#deleteprocessform').serialize(),
           dataType:'json',
           success: function(r){
                Swal.fire({
                    icon: r.status === 'ok' ? 'success' : 'error',
                    title: r.message,
                    timer: 1500
                })
                window.setTimeout(function() {
                    window.location.href = 'bussinf.php';
                }, 1500);
           },
       });

   });


//code for Users
//=============================================

// open modal only — submit handler registered once below
$(document).on('click','.addusermodal', function(e){
    e.preventDefault();
    $("#users-modal").modal('show');
});

$(document).on('click','.addusers-button', function(e){
    e.preventDefault();
    $.ajax({
        type:'post',
        url: 'usersaction.php',
        data:$("#usersform").serialize(),
        dataType:'json',
        success:function(r){
        Swal.fire({
            icon: r.status === 'ok' ? 'success' : 'error',
            title: r.message,
            timer: 1500
            })
            window.setTimeout(function(){
                window.location.href="bussinf.php";
            }, 1500);
        }
    })

});

//===============================================

//code for impact
//==========================================

// open modal only — submit handler registered once below
$(document).on('click','.addimpactmodal', function(e){
    e.preventDefault();
    $("#addimpact-modal").modal('show');
});

$(document).on('click','.addimpact-btn',function(e){
    e.preventDefault();
    $.ajax({
        type:'post',
        url:'addimpact.php',
        data:$("#addimpactform").serialize(),
        dataType:'json',
        success:function(r){
            Swal.fire({
            icon: r.status === 'ok' ? 'success' : 'error',
            title: r.message,
            timer: 1500
            })
            window.setTimeout(function(){
                window.location.href="bussinf.php";
            }, 1500);
        }

    });
});

//fetch edits
$(document).on('click','.editimpact', function(e){
    e.preventDefault();
    var impactid=$(this).attr("id");
    $.ajax({
        url:'impactedit.php',
        method:'POST',
        data:{impactid:impactid},
        dataType:"json",
        success:function(data){
            $("#iid").val(data.id);
            $("#name").val(data.name);
            $("#level").val(data.level);
            $("#impactdesc").val(data.description);

            $("#editimpact").modal('show');
        },
    })
});
//update the impact
$(document).on('click','.updateimpact', function(e){
    e.preventDefault();
    $.ajax({
        url:'impactupdate.php',
        method:'POST',
        data:$('#impactupdateform').serialize(),
        dataType:'json',
        success:function(r){
            Swal.fire({
            icon: r.status === 'ok' ? 'success' : 'error',
            title: r.message,
            timer: 1500
            })
            window.setTimeout(function(){
                window.location.href="bussinf.php";
            }, 1500);
        }
    });
});
$(document).on('click','.deleteimpact', function(e){
    e.preventDefault();
    var impactid=$(this).attr("id");
    $.ajax({
        url:'impactdelupdate.php',
        method:'POST',
        data:{impactid:impactid},
        dataType:"json",
        success:function(data){
            $("#impdelete").val(data.id);
            $("#impdcname").html(data.name);
            $("#delete-modal").modal('show');
        },

    });

});//show details
$(document).on('click','.delete-btn', function(e){
e.preventDefault();
    $.ajax({
        url:'impactdelete.php',
        method:'POST',
        data:$('#impdeleteform').serialize(),
        dataType:'json',
        success: function(r){
                Swal.fire({
                icon: r.status === 'ok' ? 'success' : 'error',
                title: r.message,
                timer: 1500
            })
            window.setTimeout(function() {
                window.location.href = 'bussinf.php';
            }, 1500);
        },
    });

});

//code for likehood
//===========================================

// open modal only — submit handler registered once below
$(document).on('click','.addlikely', function(e){
    e.preventDefault();
    $("#addlikely-modal").modal('show');
});

$(document).on('click','.addlikely-btn',function(e){
    e.preventDefault();
    $.ajax({
        type:'post',
        url:'addlikelihood.php',
        data:$("#addlikelyform").serialize(),
        dataType:'json',
        success:function(r){
            Swal.fire({
            icon: r.status === 'ok' ? 'success' : 'error',
            title: r.message,
            timer: 1500
            })
            window.setTimeout(function(){
                window.location.href="bussinf.php";
            }, 1500);
        }

    });
});

//fetch edits
$(document).on('click','.editlikelihood', function(e){
    e.preventDefault();
    var likelyid=$(this).attr("id");
    $.ajax({
        url:'likelyedit.php',
        method:'POST',
        data:{likelyid:likelyid},
        dataType:"json",
        success:function(data){
            $("#lid").val(data.id);
            $("#likelyname").val(data.name);
            $("#likelylevel").val(data.level);
            $("#ldesc").val(data.description);

            $("#editlikelihood-modal").modal('show');
        },
    })

});
//update likelihood
$(document).on('click','.updatelikely', function(e){
    e.preventDefault();
    $.ajax({
        url:'likelyupdate.php',
        method:'POST',
        data:$('#likelyupdateform').serialize(),
        dataType:'json',
        success:function(r){
            Swal.fire({
            icon: r.status === 'ok' ? 'success' : 'error',
            title: r.message,
            timer: 1500
            })
            window.setTimeout(function(){
                window.location.href="bussinf.php";
            }, 1500);
        }

    });

});
$(document).on('click','.deletelikely', function(e){
    e.preventDefault();
    var likelyid=$(this).attr("id");
    $.ajax({
        url:'likelydelupdate.php',
        method:'POST',
        data:{likelyid:likelyid},
        dataType:"json",
        success:function(data){
            $("#ldelete").val(data.id);
            $("#ldcname").html(data.name);
            $("#delete-modal").modal('show');
        },

    });

});//show details
$(document).on('click','.lklydelete-btn', function(e){
    e.preventDefault();
    $.ajax({
        url:'likelydelete.php',
        method:'POST',
        data:$('#ldeleteform').serialize(),
        dataType:'json',
        success: function(r){
                Swal.fire({
                icon: r.status === 'ok' ? 'success' : 'error',
                title: r.message,
                timer: 1500
            })
            window.setTimeout(function() {
                window.location.href = 'bussinf.php';
            }, 1500);
        },
    });

});
//==============================================================

//code for risk category
//---------------------------------------------------------------//

// open modal only — submit handler registered once below
$(document).on('click','.addriskcat', function(e){
    e.preventDefault();
    $("#riskcat-modal").modal('show');
});

$(document).on('click','.addriskcat-btn',function(e){
    e.preventDefault();
    $.ajax({
        type:'post',
        url:'riskcatAction.php',
        data:$("#addriskcatform").serialize(),
        dataType:'json',
        success:function(r){
            Swal.fire({
            icon: r.status === 'ok' ? 'success' : 'error',
            title: r.message,
            timer: 1500
            })
            window.setTimeout(function(){
                location.reload();
            }, 1500);
        }

    });
});

//fetch edits
$(document).on('click','.editriskcat', function(e){
    e.preventDefault();
    var rcid=$(this).attr("id");
    $.ajax({
        url:'riskcatedit.php',
        method:'POST',
        data:{rcid:rcid},
        dataType:"json",
        success:function(data){
            $("#rcid").val(data.riskcat_id);
            $("#riskcatname").val(data.name);
            $("#rcedesc").val(data.description);

            $("#editriskcat-modal").modal('show');
        },
    })

});
//update risk category
$(document).on('click','.updateriskcat', function(e){
    e.preventDefault();
    $.ajax({
        url:'riskcatupdate.php',
        method:'POST',
        data:$('#riskcatupdateform').serialize(),
        dataType:'json',
        success:function(r){
            Swal.fire({
            icon: r.status === 'ok' ? 'success' : 'error',
            title: r.message,
            timer: 1500
            })
            window.setTimeout(function(){
                window.location.href="bussinf.php";
            }, 1500);
        }

    });

});
$(document).on('click','.deleteriskcat', function(e){
    e.preventDefault();
    var rcid=$(this).attr("id");
    $.ajax({
    url:'riskcatedit.php',
        method:'POST',
        data:{rcid:rcid},
        dataType:"json",
        success:function(data){
            $("#rcdelete").val(data.riskcat_id);
            $("#dcname").html(data.name);
            $("#delete-modal").modal('show');
        },
    });
});
//show details
$(document).on('click','.riskcatdelete-btn', function(e){
e.preventDefault();
    $.ajax({
        url:'riskcatdelete.php',
        method:'POST',
        data:$('#rcdeleteform').serialize(),
        dataType:'json',
        success: function(r){
                Swal.fire({
                icon: r.status === 'ok' ? 'success' : 'error',
                title: r.message,
                timer: 1500
            })
            window.setTimeout(function() {
                window.location.href = 'bussinf.php';
            }, 1500);
        },
    });

});
//code for contol type
//---------------------------------------------//

// open modal only — submit handler registered once below
$(document).on('click','.addct', function(e){
    e.preventDefault();
    $("#addct-modal").modal('show');
});

$(document).on('click','.addct-btn',function(e){
    e.preventDefault();
    $.ajax({
        type:'post',
        url:'addcontroltype.php',
        data:$("#addctform").serialize(),
        dataType:'json',
        success:function(r){
            Swal.fire({
            icon: r.status === 'ok' ? 'success' : 'error',
            title: r.message,
            timer: 1500
            })
            window.setTimeout(function(){
                window.location.href="bussinf.php";
            }, 1500);
        }

    });
});

//fetch edits
$(document).on('click','.editct', function(e){
    e.preventDefault();
    var ctid=$(this).attr("id");
    $.ajax({
        url:'ctedit.php',
        method:'POST',
        data:{ctid:ctid},
        dataType:"json",
        success:function(data){
            $("#ctid").val(data.ctype_id);
            $("#ctypename").val(data.ct_name);
            $("#ctedesc").val(data.description);

            $("#editctype-modal").modal('show');
        },
    })

});
//update control type
$(document).on('click','.updatect', function(e){
    e.preventDefault();
    $.ajax({
        url:'ctupdate.php',
        method:'POST',
        data:$('#ctupdateform').serialize(),
        dataType:'json',
        success:function(r){
            Swal.fire({
            icon: r.status === 'ok' ? 'success' : 'error',
            title: r.message,
            timer: 1500
            })
            window.setTimeout(function(){
                window.location.href="bussinf.php";
            }, 1500);
        }

    });

});
//show details
$(document).on('click','.deletect', function(e){
    e.preventDefault();
         var ctid=$(this).attr("id");
         $.ajax({
               url:'ctedit.php',
               method:'POST',
               data:{ctid:ctid},
               dataType:"json",
               success:function(data){
                   $("#ctdelete").val(data.ctype_id);
                   $("#name").html(data.ct_name);
                   $("#ctdelete-modal").modal('show');
               },
         });

       });

//delete
$(document).on('click','.ctypedelete-btn', function(e){
e.preventDefault();
    $.ajax({
        url:'ctdelete.php',
        method:'POST',
        data:$('#ctypedeleteform').serialize(),
        dataType:'json',
        success: function(r){
                Swal.fire({
                icon: r.status === 'ok' ? 'success' : 'error',
                title: r.message,
                timer: 5500
            })
            window.setTimeout(function() {
                window.location.href = 'bussinf.php';
            }, 5500);
        },
    });

});
//code end control type buss info//
//-----------------------------------------------------------//

//code for control strength
//------------------------------------------------------------//

// open modal only — submit handler registered once below
$(document).on('click','.addcs', function(e){
    e.preventDefault();
    $("#addcs-modal").modal('show');
});

$(document).on('click','.addcs-btn',function(e){
    e.preventDefault();
    $.ajax({
        type:'post',
        url:'addcontrolstrength.php',
        data:$("#addcsform").serialize(),
        dataType:'json',
        success:function(r){
            Swal.fire({
            icon: r.status === 'ok' ? 'success' : 'error',
            title: r.message,
            timer: 1500
            })
            window.setTimeout(function(){
                window.location.href="bussinf.php";
            }, 1500);
        }

    });
});

//fetch edits
$(document).on('click','.editcs', function(e){
    e.preventDefault();
    var csid=$(this).attr("id");
    $.ajax({
        url:'csedit.php',
        method:'POST',
        data:{csid:csid},
        dataType:"json",
        success:function(data){
            $("#csid").val(data.strength_id);
            $("#csname").val(data.cs_name);
            $("#csdesc").val(data.description);

            $("#editcs-modal").modal('show');
        },
    })

});
//update the control strength
$(document).on('click','.updatecs', function(e){
    e.preventDefault();
    $.ajax({
        url:'csupdate.php',
        method:'POST',
        data:$('#editcsform').serialize(),
        dataType:'json',
        success:function(r){
            Swal.fire({
            icon: r.status === 'ok' ? 'success' : 'error',
            title: r.message,
            timer: 1500
            })
            window.setTimeout(function(){
                window.location.href="bussinf.php";
            }, 1500);
        }

    });

});
//show delete
$(document).on('click','.deletecs', function(e){
e.preventDefault();
    var csid=$(this).attr("id");
    $.ajax({
    url:'csedit.php',
        method:'POST',
        data:{csid:csid},
        dataType:"json",
        success:function(data){
            $("#csdelete").val(data.strength_id);
            $("#dcname").html(data.cs_name);
            $("#csdelete-modal").modal('show');
        },

    });

});//show details
$(document).on('click','.csdelete-btn', function(e){
e.preventDefault();
    $.ajax({
        url:'csdelete.php',
        method:'POST',
        data:$('#csdeleteform').serialize(),
        dataType:'json',
        success: function(r){
                Swal.fire({
                icon: r.status === 'ok' ? 'success' : 'error',
                title: r.message,
                timer: 1500
            })
            window.setTimeout(function() {
                window.location.href = 'bussinf.php';
            }, 1500);
        },
    });

});
//end of control strength
//---------------------------------------------------------------//


