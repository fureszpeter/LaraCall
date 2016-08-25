var bindForms=function(){
    $("form.ajax-form-bind[data-processed!=1]")
            .on("submit", function(e) {
                e.preventDefault();
                console.log("Submitting form. Action: " + $(this).attr("action"));
                console.log("data: " + $(this).serialize());
                ajaxLoading();
                var _this=this;
                $.post($(this).attr("action"), $(this).serialize() + "&ajaxrequest=1")
                        .done(function(data) {
                            ajaxStop(true);
                            dataParser(data);
                        })
                        .fail(function() {
                            ajaxStop(false);
                        })
                        .always(function() {
                            //ajaxStop(true);
                            //Remove the added hidden at click
                            $(_this).find(".clickAdd").remove();
                        });

                return false;
            })
            .attr("data-processed", 1)
            .find("input[type=submit],button[type=submit]").on("click", function() {
                if ($(this).attr("name")) {
                    $(this).closest("form").append("<input type='hidden' class='clickAdd' name='" + $(this).attr("name") + "' value='" + ($(this).val() || $(this).html()) + "'>");
                }
            });
};


$(document).ready(function() {
    bindForms();
});





var dataParser = function(data) {
    if (data !== null) {
        console.log("Data response received");
        console.log(data);
        if (typeof data.response_version !== "undefined" && data.response_version == "2.0") {
            //Response V2.0
            console.log("V2.0 response version received");
            ParseAjaxResponse2(data.responses);
        } else {
            console.log("V1.0 response version received");
            ParseAjaxResponse(data);
        }
    }
    else {
        console.log('No data response');
    }
};

var ParseAjaxResponse = function(ResponseObject) {
    console.log("Ajax response received.");
    console.log("Response object: ");
    console.log(ResponseObject);
    //console.log('nesze: ' + (typeof ResponseObject.redirect));
    if (typeof ResponseObject.redirect === 'undefined' || typeof ResponseObject.redirect === 'null') {
//do nothing
    } else {
        document.location.href = ResponseObject.redirect;
        return true;
    }
    if (ResponseObject.html === undefined) {
//no html response, don't do anything
        console.log("No html response!");
    } else {
        console.log("WE got html response!");
        $("#" + ResponseObject.target).empty().append(ResponseObject.html);
        bindForms();
    }
    $(ResponseObject.renderList).each(function(elem, index, myArray) {
        refreshDiv(index);
    });
    $(ResponseObject.callBackList).each(function(elem, index, myArray) {
        console.log("CallBack called: ");
        if (typeof index !== 'undefined' && typeof window[index] === "function") {
            console.log("Function found: " + index);
            window[index]();
            bindForms();
        } else {
            alert("not a function: " + index);
            //messageLoader();
        }

    });
    console.log(ResponseObject);
}

function isFunctionDefined(functionName) {
    if (eval("typeof(" + functionName + ") == typeof(Function)")) {
        return true;
    } else {
        return false;
    }
}

var ParseAjaxResponse2 = function(ResponseObject) {
    console.log("Parsing response V2");
    console.log(ResponseObject);
    $(ResponseObject).each(function(index, value) {
        if (typeof value.response_type !== "undefined" && value.response_type === "redirect") {
            //redirect request
            console.log("Redirect request detected" + value.redirect);
            document.location.href = value.redirect;
            return true;
        } else if (typeof value.response_type !== "undefined" && value.response_type === "div_direct" && typeof value.target !== "undefined" && value.content !== "undefined") {
            //div_direct request
            console.log("Direct content request detected");
            $("#" + value.target).empty().append(value.content);
        } else if (typeof value.response_type !== "undefined" && value.response_type === "callback" && typeof value.target !== "undefined" && value.content !== "undefined") {
            if (value.target && isFunctionDefined(value.target)) {
                console.log("Callback function exists: " + value.target);
                eval(value.target + "(value.content);");
            } else {
                console.log("Callback function NOT exists: " + value.target);
            }
        }
        console.log("Response object " + index);
        console.log(value);
    });
    bindForms();
};

var refreshDiv = function(divName) {
    console.log("Start refreshing div: " + divName);
    var url = $("#" + divName).attr("src");
    $("#" + divName).load(
            url + "/?noheader=1",
            function(response, status, xhr) {
                if (status == "success") {
                    $("#" + divName).css("display", "");
                    console.log("Div (" + divName + ") loaded successfully: " + url + "/?noheader=1");
                    alert("loaded");
                    bindForms();
                    //alert("ok: " + status + response);
                } else {
                    console.log("Div failed to load");
                    alert("hiba: " + status);
                }
            }
    );
};

var addMessage = function(message, type) {
    var container = $("<div>" + message + "</div>").addClass("message").addClass(type);
    var closer = $("<div>Close[X]</div>").addClass("closeMessage");
    closer.appendTo(container);
    $("#messageContainer").append(container);
};


var callbackMessage = function(input) {
    if (input.type == "error") {
        addMessage(input.message, "error");
    } else if (input.type == "info") {
        addMessage(input.message, "info");
    } else {
        return false;
    }
    if (typeof bindMessage == "function")
        bindMessage();
};
