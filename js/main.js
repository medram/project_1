'use struct';

window.onload = function (){


	addEvents();
};

function addEvents()
{
	changeLanguage();
}

function changeLanguage()
{
	let select = document.getElementById('lang');

	select.addEventListener('change', function (){
		window.location.href = '?lang='+this.value;
	});
}

