<?php
	include "url.php";
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../style.css" />
<link rel="stylesheet" type="text/css" href="../c.min.css" />
<script src="../c.min.js"></script>
<title>Лабораторная</title>
</head>

<body>
<div id="container">
        <div id="header">
            <a href="../index.html"><h1>Random</h1></a>
        </div>
       <!-- Верхнее меню -->
        <div id="menu">
            <ul>
                <li class="menuitem"><a href="lab1.php">Равномерное распределение</a></li>
                <li class="menuitem"><a href="lab2.php" class="active">Распределение Симпсона</a></li>
                <li class="menuitem"><a href="lab3.php">Нормальное распределение</a></li>
                <li class="menuitem"><a href="lab4.php">Экспоненциальное распределение</a></li>
                <li class="menuitem"><a href="lab5.php">Распределение Эрланга</a></li>
            </ul>
        </div>
        <!-- Содержимое страницы -->
        <div class="content">
            <h2>Лабораторная работа</h2>
            <br/>

<div class="gg">
    <h3>Числа</h3> <input type="text" id="num" value="">
    <h3>Интервалы</h3> <input type="text" id="int" value="">
    <br/>
    <br/>
    <input type="radio" name="metod" value="2" checked="true"> Треугольное распределение<br/>
    <input type="radio" name="metod" value="1"> Трапецеидальное распределение<br/>
    <br/>
<input id="but" type="button" value="Построить график">
</div>

<div class="graph">
	<div class="ct-chart ct-perfect-fourth"></div>
</div>
<script>
function sortNumber(a, b){
return a - b;
}
function getRand(min, max){
	return Math.random() * (max - min) + min;
}
function getMasRand(len, min, max){
	var mas = [];
			for (var i = 0; i < len; i++){
				mas[i] = Math.random() * (max - min) + min;
				//console.log(mas[i]);
			};
			mas.sort(sortNumber);
			//console.log(mas);
			return mas;
}
function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}
function unique(arr) {
  var result = [];

  nextInput:
    for (var i = 0; i < arr.length; i++) {
      var str = arr[i]; 
      for (var j = 0; j < result.length; j++) { 
        if (result[j] == str) continue nextInput; 
      }
      result.push(str);
    }
  return result;
}

document.getElementById('but').onclick = function() {
	//var start = new Date().getTime();
	if(isNumeric(document.getElementById('num').value) && isNumeric(document.getElementById('int').value)){

	var mas = [], vhod = [], ver = [], Sver = [], trap = [], intervalS = [], series = [], ticks = [];
	var colElem = 1000, interval = 25, count = 0, box = 0, metod = 1;
	colElem = Math.abs(document.getElementById('num').value);
	interval = Math.abs(document.getElementById('int').value);
	metod = +document.querySelector('input[name="metod"]:checked').value;
	if(metod == 1){
		var M = 0, D = 0, x = 10, a = 50, l = a, l1 = 0, l2 = 0, b = Math.round(l/2);
		var t = 0, p1 = a - l, p2 = a - b, p3 = a + b, p4 = a + l, k = 0;
	}else{
		var x = 10, a = 0, b = 1;
		var p1 = a, p3 = (a+b)/2, p4 = b, k = 0;
	}

	
	//D = Math.abs(document.getElementById('d').value);
	//x = Math.abs(document.getElementById('x').value);
	
	
	mas = getMasRand(colElem,  p1, p4);
	min = mas[0];
	max = mas[colElem-1];
	//console.log('max-> ' + max);
	//console.log('min-> ' + min);
	step = (max - min) / interval; 
	//console.log('step-> ' + step);
	intervalS[0] = min;
	var i = 1
	while (box < max){
		box = intervalS[i-1] + step;
		intervalS[i] = box;
		i++;
	}//for (var i = 0; i < intervalS.length; i++) {
	//	console.log('min-> ' + intervalS[i] + ' max-> ' + intervalS[i+1]);
	//};console.log(b);console.log(l);console.log(p1);console.log(p2);console.log(p3);console.log(p4);
	box = 0;
	var m = 0;
	for (var i = 0; i < intervalS.length; i++) {
		count = 0;
		for (m = box; m < mas.length; m++) {
			if(mas[m] >= intervalS[i] && mas[m] <= intervalS[i+1]){
				count++;
			}else{
				box = m;
				break;
			}
			//console.log('min-> ' + intervalS[i] + ' >' + mas[m] + '< ' + intervalS[i+1] + ' <-max');
		};
		ver[i] = +(count/mas.length).toFixed(3);
		M += intervalS[i] * ver[i];
	};

	if(metod == 1){
		for (var i = 0; i < a; i++) {
			if(intervalS[i] >= p1 && intervalS[i] <= p2){
				trap[i] = ((intervalS[i] - a + l)/(l*l - b*b)) * getRand(0.95, 0.999)
				//console.log('1 = ' + trap[i]);
			}else if(intervalS[i] >= p2 && intervalS[i] <= p3){
				trap[i] = (1/(l+b) ) * getRand(0.95, 0.999);
				//console.log('2 = ' + trap[i]);
			}else if(intervalS[i] >= p3 && intervalS[i] <= p4){
				trap[i] = ((a + l - intervalS[i])/(l*l - b*b)) * getRand(0.95, 0.999);
				//console.log('3 = ' + trap[i]);
			}
		};
	}else{
		for (var i = 0; i < intervalS.length; i++) {
			if(intervalS[i] >= a && intervalS[i] < p3){
				trap[i] = (4 * (intervalS[i] - a)/Math.pow((b - a), 2)) * getRand(0.9, 0.999);
				//console.log('1 = ' + trap[i]);
			}else if(intervalS[i] > p3 && intervalS[i] <= b){
				trap[i] = ((4 * (b - intervalS[i]))/Math.pow((b - a), 2)) * getRand(0.9, 0.999);
				//console.log('2 = ' + trap[i]);
			}
		};
	}

	

	//console.log(ver);

	/*
	var co = 1, nn = 1, cc = 0;
	for (var i = 0; i < ver.length; i++) {
		switch(co){
			case 1: 
				Sver[ver.length - cc] = ver[i];
				cc++;
				co = 2;
				break;
			case 2: 
				Sver[nn] = ver[i];
				nn++;
				co = 1;
				break;
		}
	};
	console.log(Sver);*/
	
	for (var i = 0; i < intervalS.length; i++) {
		series.push(trap[i]);
	};

	if(metod == 1){
		for (var i = 0; i < intervalS.length; i++) {
			ticks.push(+intervalS[i].toFixed(2));
		}
	}else{
		for (var i = 0; i < intervalS.length; i++) {
			ticks.push(+intervalS[i].toFixed(2));
		}
	}
    
	//ticks = unique(ticks);
	//console.log(series);
	//console.log(ticks);

		var data = {
		  labels: ticks,
		  series: [
		    series
		  ]
		};

		var options = {
		  seriesBarDistance: 10
		};

		var responsiveOptions = [
		  ['screen and (max-width: 640px)', {
		    seriesBarDistance: 5,
		    axisX: {
		      labelInterpolationFnc: function (value) {
		        return value[0];
		      }
		    }
		  }]
		];

		new Chartist.Bar('.ct-chart', data, options, responsiveOptions);

	}else{
		alert('Введите число !');
	}

	//var elapsed = new Date().getTime() - start; // рассчитаем время выполнения
	//console.log(elapsed);
}
		//lineSmooth: Chartist.Interpolation.cardinal({
    	//	tension: 0.1
  		//}),
</script>
            
      </div>
</div>
</body>
</html>