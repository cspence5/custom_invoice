

(function (document) {
	var
	head = document.head = document.getElementsByTagName('head')[0] || document.documentElement,
	elements = 'article aside audio bdi canvas data datalist details figcaption figure footer header hgroup mark meter nav output picture progress section summary time video x'.split(' '),
	elementsLength = elements.length,
	elementsIndex = 0,
	element;

	while (elementsIndex < elementsLength) {
		element = document.createElement(elements[++elementsIndex]);
	}

	element.innerHTML = 'x<style>' +
		'article,aside,details,figcaption,figure,footer,header,hgroup,nav,section{display:block}' +
		'audio[controls],canvas,video{display:inline-block}' +
		'[hidden],audio{display:none}' +
		'mark{background:#FF0;color:#000}' +
	'</style>';

	return head.insertBefore(element.lastChild, head.firstChild);
})(document);

/* Prototyping
/* ========================================================================== */

(function (window, ElementPrototype, ArrayPrototype, polyfill) {
	function NodeList() { [polyfill] }
	NodeList.prototype.length = ArrayPrototype.length;

	ElementPrototype.matchesSelector = ElementPrototype.matchesSelector ||
	ElementPrototype.mozMatchesSelector ||
	ElementPrototype.msMatchesSelector ||
	ElementPrototype.oMatchesSelector ||
	ElementPrototype.webkitMatchesSelector ||
	function matchesSelector(selector) {
		return ArrayPrototype.indexOf.call(this.parentNode.querySelectorAll(selector), this) > -1;
	};

	ElementPrototype.ancestorQuerySelectorAll = ElementPrototype.ancestorQuerySelectorAll ||
	ElementPrototype.mozAncestorQuerySelectorAll ||
	ElementPrototype.msAncestorQuerySelectorAll ||
	ElementPrototype.oAncestorQuerySelectorAll ||
	ElementPrototype.webkitAncestorQuerySelectorAll ||
	function ancestorQuerySelectorAll(selector) {
		for (var cite = this, newNodeList = new NodeList; cite = cite.parentElement;) {
			if (cite.matchesSelector(selector)) ArrayPrototype.push.call(newNodeList, cite);
		}

		return newNodeList;
	};

	ElementPrototype.ancestorQuerySelector = ElementPrototype.ancestorQuerySelector ||
	ElementPrototype.mozAncestorQuerySelector ||
	ElementPrototype.msAncestorQuerySelector ||
	ElementPrototype.oAncestorQuerySelector ||
	ElementPrototype.webkitAncestorQuerySelector ||
	function ancestorQuerySelector(selector) {
		return this.ancestorQuerySelectorAll(selector)[0] || null;
	};
})(this, Element.prototype, Array.prototype);

/* Helper Functions
/* ========================================================================== */

function generateTableRow() {
	var emptyColumn = document.createElement('tr');

	emptyColumn.innerHTML = '<td><a class="cut">-</a><span contenteditable></span></td>' +
		'<td><span contenteditable></span></td>' +
		'<td><span data-prefix>$</span><span contenteditable>0.00</span></td>' +
		'<td><span contenteditable></span></td>' +
		'<td><span data-prefix>$</span><span>0.00</span></td>';

	return emptyColumn;
}

function parseFloatHTML(element) {
	return parseFloat(element.innerHTML.replace(/[^\d\.\-]+/g, '')) || 0;
}

function parsePrice(number) {
	return number.toFixed(2).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1,');
}

/* Update Number
/* ========================================================================== */

function updateNumber(e) {
	var
	activeElement = document.activeElement,
	value = parseFloat(activeElement.innerHTML),
	wasPrice = activeElement.innerHTML == parsePrice(parseFloatHTML(activeElement));

	if (!isNaN(value) && (e.keyCode == 38 || e.keyCode == 40 || e.wheelDeltaY)) {
		e.preventDefault();

		value += e.keyCode == 38 ? 1 : e.keyCode == 40 ? -1 : Math.round(e.wheelDelta * 0.025);
		value = Math.max(value, 0);

		activeElement.innerHTML = wasPrice ? parsePrice(value) : value;
	}

	updateInvoice();
}

/* Update Invoice
/* ========================================================================== */

function updateInvoice() {
	var total = 0;
	var cells, price, total, a, i;
    //  var header = document.querySelectorAll(".T");
     //var x = document.getElementsByClassName("T");
	//x.innerHTML = 'Test';
	//  header.text = 'Test';	 
	//console.log(x.innerHTML);
	// ======================

	
	var regular_rates = [];
	var regular_hours = [];
	var overtime_rates = [];
	var overtime_hours = [];
	
        for (var a = document.getElementsByClassName('rRate'), i = 0; a[i]; ++i) {
        
            regular_rates.push(a[i]);
        
        
        }
        
        
             for (var a = document.getElementsByClassName('rHours'), i = 0; a[i]; ++i) {
        
            regular_hours.push(a[i]);
        
        
        }
        
        
         for (var a = document.getElementsByClassName('oRate'), i = 0; a[i]; ++i) {
        
            overtime_rates.push(a[i]);
        
        
        }
        
        
        
        
        
        
          for (var a = document.getElementsByClassName('oHours'), i = 0; a[i]; ++i) {
        
            overtime_hours.push(a[i]);
        
        
        }
        
        
         for (var a = document.getElementsByClassName('rRate'), i = 0; a[i]; ++i) {
        

            
         var regular_totals = parseFloatHTML(regular_rates[i]) * parseFloatHTML(regular_hours[i]); 
    	 var overtime_totals = parseFloatHTML(overtime_rates[i]) * parseFloatHTML(overtime_hours[i]);   	
          
            price = regular_totals + overtime_totals; 
    		 
		document.getElementsByClassName("lTotal")[i].innerHTML = price; 
            
            
        
        
        }
	
	
	
	
	
	
	
	
	var rates = [];
	var quantities = [];
	var taxes = [];
	var tax_rate = document.getElementsByClassName('tRate')[0].innerHTML;
	console.log(tax_rate);
	
	
	
	
	       for (var a = document.getElementsByClassName('mRate'), i = 0; a[i]; ++i) {
	             
                // console.log(parseFloatHTML(a[i]));
                 rates.push(a[i]);
				 
	     	}
			
			
			   for (var a = document.getElementsByClassName('mQuantity'), i = 0; a[i]; ++i) {
	
                 
                quantities.push(a[i]);
				 
	     	}
	     
		    for (var a = document.getElementsByClassName('mTax'), i = 0; a[i]; ++i) {
	
                 
                taxes.push(a[i]);
				 
	     	}
		 
		 
		    for (var a = document.getElementsByClassName('mRate'), i = 0; a[i]; ++i) {
	
	        //tax = parseFloatHTML(tax_rate);
               cost = parseFloatHTML(rates[i]) * parseFloatHTML(quantities[i]);  
               price = parseFloatHTML(rates[i]) * parseFloatHTML(quantities[i]);
               tax_cost = cost * (tax_rate/100);
               price = price + tax_cost; 
               
               
    		   total += price;   
    		document.getElementsByClassName("mTax")[i].innerHTML = tax_cost;   
    		document.getElementsByClassName("mCost")[i].innerHTML = cost;   
		document.getElementsByClassName("mTotal")[i].innerHTML = price; 
	     	}
     
	 
	 
	 var rental_quantities = [];
	 var rental_days = [];
	 var rental_rates = [];
	
	 
 
	 
	
	
	
	  for (var a = document.getElementsByClassName('eQuantity'), i = 0; a[i]; ++i) {
	
                 
                rental_quantities.push(a[i]);
				 
	     	}
	 
	  for (var a = document.getElementsByClassName('eDays'), i = 0; a[i]; ++i) {
	
                 
                rental_days.push(a[i]);
				 
	     	}
	 
	  for (var a = document.getElementsByClassName('eRate'), i = 0; a[i]; ++i) {
	
                 
                rental_rates.push(a[i]);
				 
	     	}
	 
	     for (var a = document.getElementsByClassName('eQuantity'), i = 0; a[i]; ++i) {
	
               price = parseFloatHTML(rental_quantities[i]) * parseFloatHTML(rental_days[i]) * parseFloatHTML(rental_rates[i]);  
              
    		   total += price;   
    		
		document.getElementsByClassName("eTotal")[i].innerHTML = price; 
	     	}
	
	
	  var material_totals = [];
	  var labor_totals = [];
	  var rental_totals = [];
	   var final_total = 0;
 
	for (var a = document.getElementsByClassName('mTotal'), i = 0; a[i]; ++i) {
	
	  var material = parseFloatHTML(a[i]);
	  
	  final_total = final_total + material;
	
	
	}
	
	
	document.getElementsByClassName('material_total')[0].innerHTML = final_total;
	final_total = 0;
	
	
	
	for( var a = document.getElementsByClassName('lTotal'), i = 0; a[i]; ++i) {
	    
	  var labor = parseFloatHTML(a[i]);
	  final_total = final_total + labor;
	    
	
	}
	
	document.getElementsByClassName('labor_total')[0].innerHTML =  final_total;
	final_total = 0;
	
	
	
	for( var a = document.getElementsByClassName('eTotal'), i = 0; a[i]; ++i) {
	
	    var rental = parseFloatHTML(a[i]);
	    final_total = final_total + rental;
	
	
	}
	
	
	document.getElementsByClassName('rental_total')[0].innerHTML = final_total;
	final_total = 0;
	
	
	
	
	
	
	
	
	
	

	// update balance cells
	// ====================

	// get balance cells
	cells = document.querySelectorAll('table.balance td:last-child span:last-child');

	// set total
	cells[0].innerHTML = total;

	// set balance and meta balance
	cells[2].innerHTML = document.querySelector('table.meta tr:last-child td:last-child span:last-child').innerHTML = parsePrice(total - parseFloatHTML(cells[1]));

	// update prefix formatting
	// ========================

	var prefix = document.querySelector('#prefix').innerHTML;
	for (a = document.querySelectorAll('[data-prefix]'), i = 0; a[i]; ++i) a[i].innerHTML = prefix;

	// update price formatting
	// =======================

	for (a = document.querySelectorAll('span[data-prefix] + span'), i = 0; a[i]; ++i) if (document.activeElement != a[i]) a[i].innerHTML = parsePrice(parseFloatHTML(a[i]));

	  //  document.getElementsByClassName("TL").innerHTML = 'Total'; 
	//	console.log(document.getElementsByClassName("TL").innerHTML);
	}

/* On Content Load
/* ========================================================================== */

function onContentLoad() {
	updateInvoice();

	var
	input = document.querySelector('input'),
	image = document.querySelector('img');

	function onClick(e) {
		var element = e.target.querySelector('[contenteditable]'), row;

		element && e.target != document.documentElement && e.target != document.body && element.focus();

		if (e.target.matchesSelector('.add.labor')) {
		   document.querySelector('table.inventory.labor tbody').appendChild(generateTableRow());
		//	document.querySelector('table.material tbody').appendChild(generateTableRow());
		}
		else if (e.target.className == 'cut') {
			row = e.target.ancestorQuerySelector('tr');

			row.parentNode.removeChild(row);
		}
		
		
		
			if (e.target.matchesSelector('.add.material')) {
		document.querySelector('table.inventory.material tbody').appendChild(generateTableRow());
			//document.querySelector('table.material tbody').appendChild(generateTableRow());
		}
		else if (e.target.className == 'cut') {
			row = e.target.ancestorQuerySelector('tr');

			row.parentNode.removeChild(row);
		}
		
		
		
		
				if (e.target.matchesSelector('.add.rental')) {
		document.querySelector('table.inventory.rental tbody').appendChild(generateTableRow());
			//document.querySelector('table.material tbody').appendChild(generateTableRow());
		}
		else if (e.target.className == 'cut') {
			row = e.target.ancestorQuerySelector('tr');

			row.parentNode.removeChild(row);
		}
		
		
		
		
		
		
		
		
		
		
		

		updateInvoice();
		 

	}

	function onEnterCancel(e) {
		e.preventDefault();

		image.classList.add('hover');
	}

	function onLeaveCancel(e) {
		e.preventDefault();

		image.classList.remove('hover');
	}

	function onFileInput(e) {
		image.classList.remove('hover');

		var
		reader = new FileReader(),
		files = e.dataTransfer ? e.dataTransfer.files : e.target.files,
		i = 0;

		reader.onload = onFileLoad;

		while (files[i]) reader.readAsDataURL(files[i++]);
	}

	function onFileLoad(e) {
		var data = e.target.result;

		image.src = data;
	}

	if (window.addEventListener) {
		document.addEventListener('click', onClick);

		document.addEventListener('mousewheel', updateNumber);
		document.addEventListener('keydown', updateNumber);

		document.addEventListener('keydown', updateInvoice);
		document.addEventListener('keyup', updateInvoice);

		input.addEventListener('focus', onEnterCancel);
		input.addEventListener('mouseover', onEnterCancel);
		input.addEventListener('dragover', onEnterCancel);
		input.addEventListener('dragenter', onEnterCancel);

		input.addEventListener('blur', onLeaveCancel);
		input.addEventListener('dragleave', onLeaveCancel);
		input.addEventListener('mouseout', onLeaveCancel);

		input.addEventListener('drop', onFileInput);
		input.addEventListener('change', onFileInput);
	}
}

window.addEventListener && document.addEventListener('DOMContentLoaded', onContentLoad);