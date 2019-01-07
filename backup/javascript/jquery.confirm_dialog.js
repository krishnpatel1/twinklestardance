/***********************************************************
# jquery.confirm_dialog.js jQuery Confirm Dialog
# Copyright (C) 2009 Stephen DeGrace
# stephen@infiniterecursion.ca
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Lesser General Public License as published
# by the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU Lesser General Public License for more details.
************************************************************/

/**
This is a jQueryUI dialog version of the traditional Javascript
window.confirm() method. Given as this is not a "real" dialog and
the calling script is incapable of waiting for the dialog to "return,"
since it really doesn't, the usage is a little different.

PREREQUISITES:

jQuery, jQueryUI Dialog (and Draggable if you want the dialog to be
draggable).

TO USE:

The plugin exposes two functions, $.confirmDialog and $.confirmDialog.defaults.
No members act on the jQuery object. The plugin actually creates a div and
adds it to the DOM the first time it is used, and always acts on this element.
The confirmDialog function open the dialog with the options you specify, and
executes the callback you pass in if the user responds affirmative. The
confirmDialog.defaults function changes the default options.

NOTE: This implementation reuses one dialog, so you should not have a situation
where a confirmDialog is called while one is open and waiting for user input.

PUBLIC MEMBERS:

jQuery.confirmDialog.defaults(options)

    Call any time to change the default options for all future confirmDialog
    calls.

jQuery.confirmDialog(options, callback)

    Call to open and use the dialog. Callback will be executed if the user
    selects affirmative.

USAGE:

To use the dialog with a custom message:

$.confirmDialog({msg: "Do you wanna say hi?"}, function () {
    alert("hi");
});

To change the defaults for future calls:

$.confirmDialog.defaults({
    yes: "Oui",
    no: "Non",
    title: "Confirmation exigé",
    msg: "Est-ce que vous voulez continuer?"
});

OPTIONS:

Same options for both functions, it is mandatory in using the
confirmDialog function to at minimum pass an empty object for options.

yes: Text for affirmative user response button, defaults to "Yes"
no: Text for negative user response button, defaults to "No"
title: Default dialog title, defaults to "Confirmation Required"
msg: Text to present to user, defaults to "Do you wish to proceed?"
**/

(function ($) {
    var Defaults = function () {};
    $.extend(Defaults.prototype, {
        yes: "Yes",
        no: "No",
        title: "Confirmation Required",
        msg: "Do you wish to proceed?"
    });
    
    $.confirmDialog = function (options, callback) {
        // Pass the options and a callback to execute if affirmative user
        // response.
        var opts = new Defaults();
        $.extend(opts, options);
        
        var exit_status = 0;
    
        var yesFunc = function () {
            exit_status = 1;
            $(this).dialog('close');
        }
        var noFunc = function () {
            exit_status = 0;
            $(this).dialog('close');
        }
        
        var dlg = $('body').append("<div></div>").find('div:last')
                .dialog({
                    autoOpen: false,
                    modal: false,
                    close: function () {
                        // Clean up
                        dlg.dialog('destroy').remove();
                    }
            });
        
        // Set options, open, and bind callback
        var buttons = new Object();
        buttons[opts.no] = noFunc;
		 buttons[opts.yes] = yesFunc;
        dlg.dialog('option', 'title', opts.title);
        dlg.dialog('option', 'buttons', buttons);
        dlg.text(opts.msg ? opts.msg : "&nbsp;").dialog('open')
            .one('dialogclose', function () {
                if (exit_status) {
                    callback();
                }
        });
    }
    
    $.confirmDialog.defaults = function (options) {
        $.extend(Defaults.prototype, options);
    }
    
})(jQuery);
