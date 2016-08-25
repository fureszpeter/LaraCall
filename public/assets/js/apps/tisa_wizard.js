
$(function() {
    // wizard
    tisa_wizard.init();
    // select country
    // select languages
    // form validation
})


// wizard
tisa_wizard = {
    init: function() {

        if ($("#wizard_form").length) {
            var wizard_form = $('#wizard_form');
            // initialize wizard
            wizard_form.steps({
                headerTag: 'h3',
                bodyTag: "section",
                enableAllSteps: false,
                saveState: true,
                titleTemplate: "<span class=\"number\">#index#.</span><span class=\"title\">#title#</span>",
                transitionEffect: "slideLeft",
                labels: {
                    next: "Next Step <i class=\"fa fa-angle-right\"></i>",
                    previous: "<i class=\"fa fa-angle-left\"></i> Previous Step",
                    current: "",
                    finish: "<i class=\"fa fa-check\"></i> Complete order"
                },
                onStepChanging: function(event, currentIndex, newIndex) {
                    tisa_wizard.setContentHeight('#wizard_form');
                    //$("#wizard_form section").eq(currentIndex).children("form").submit();
                    //alert(currentIndex);
                    return true;
                },
                onStepChanged: function(event, currentIndex, priorIndex) {
                    alert("itt");
                },
                onFinishing: function(event, currentIndex) {


                },
                onFinished: function(event, currentIndex) {
                    alert("Submitted!");
                    //* uncomment the following line to submit form
                    wizard_form.submit();
                }
            });
            // set initial wizard height
            tisa_wizard.setContentHeight('#wizard_form');
        }
    },
    setContentHeight: function($wizard) {
        setTimeout(function() {
            var cur_height = $($wizard).children('.content').children('.body.current').outerHeight();
            $($wizard).find('.content').height(cur_height);
        }, 0);
    }
}


