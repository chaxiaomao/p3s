/*! CCA2 BO app.js
 * ================
 * Main JS application file for CCA2 BackOffice. This file
 * should be included in all pages. It controls some layout
 *
 * @Author  Ben Bi
 * @Support <http://www.cciza.com>
 * @Email   <support@cciza.com>
 * @version 2.0.0
 * @license MIT <http://opensource.org/licenses/MIT>
 */

//Make sure jQuery has been loaded before app.js
if (typeof jQuery === "undefined") {
    throw new Error("CCA2 requires jQuery");
}

/* C2App
 *
 * @type Object
 * @description $.C2App is the main object for the template's app.
 *              It's used for implementing functions and options related
 *              to the template. Keeping everything wrapped in an object
 *              prevents conflict with other plugins and is a better
 *              way to organize our code.
 */
$.C2App = {
    modalFullscreen: function(){
        $(document).on('click', 'button.fa-window-maximize', function(){
             $(this).closest("div[role='dialog']").toggleClass('modal-fullscreen');
             $(this).toggleClass(function(){
               if ($(this).is('.fa-window-maximize')) {
                    return 'fa-window-minimize';
                  } else {
                    return 'fa-window-maximize';
                  }
             });
           });
    }
};

/* --------------------
 * - C2App Options -
 * --------------------
 * Modify these options to suit your implementation
 */
$.C2App.options = {
};

/* ------------------
 * - Implementation -
 * ------------------
 * The next block of code implements C2App's
 * functions and plugins as specified by the
 * options above.
 */
$(function () {
    "use strict";

    //Extend options if external options exist
    if (typeof C2AppOptions !== "undefined") {
        $.extend(true,
                $.C2App.options,
                C2AppOptions);
    }

    //Easy access to options
    var o = $.C2App.options;

    //Set up the object
    _init();

    /* ----------------------------------
     * - Initialize the C2App Object -
     * ----------------------------------
     * All C2App functions are implemented below.
     */
    function _init() {
        'use strict';
        $.C2App.modalFullscreen();
    }
    
});

