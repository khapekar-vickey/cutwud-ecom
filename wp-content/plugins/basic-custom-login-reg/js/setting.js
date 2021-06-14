jQuery(document).ready( function($) {
var textBox = document.getElementById("wpumcopydata");
  
    textBox.onfocus = function() {
        textBox.select();

        // Work around Chrome's little problem
        textBox.onmouseup = function() {
            // Prevent further mouseup intervention
            textBox.onmouseup = null;
            return false;
        };
    };

    var textBox1 = document.getElementById("wpumcopyshortcode");
    textBox1.onfocus = function() {
        textBox1.select();

        // Work around Chrome's little problem
        textBox1.onmouseup = function() {
            // Prevent further mouseup intervention
            textBox1.onmouseup = null;
            return false;
        };
    };

    var textBox2 = document.getElementById("wpumcopyshortcode1");
    textBox2.onfocus = function() {
        textBox2.select();

        // Work around Chrome's little problem
        textBox2.onmouseup = function() {
            // Prevent further mouseup intervention
            textBox2.onmouseup = null;
            return false;
        };
    };

});