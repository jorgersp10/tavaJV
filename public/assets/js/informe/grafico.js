// Inmuebles
const scigs = document.getElementById('saldo_cuo_inm_gs');
const svigs = document.getElementById('saldo_ven_inm_gs');

const scius = document.getElementById('saldo_cuo_inm_us');
const svius = document.getElementById('saldo_ven_inm_us');
// Vehiculos
const scmgs = document.getElementById('saldo_cuo_mue_gs');
const svmgs = document.getElementById('saldo_ven_mue_gs');

const scmus = document.getElementById('saldo_cuo_mue_us');
const svmus = document.getElementById('saldo_ven_mue_us');
// Acuerdos
const scags = document.getElementById('saldo_cuo_acu_gs');
const svags = document.getElementById('saldo_ven_acu_gs');

const scaus = document.getElementById('saldo_cuo_acu_us');
const svaus = document.getElementById('saldo_ven_acu_us');

scags.addEventListener("change", () =>{
    $.ChartJs.init();
});
/******/ (function() { // webpackBootstrap
/*!********************************************!*\
  !*** ./resources/js/pages/chartjs.init.js ***!
  \********************************************/
/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: ChartJs init Js File
*/
!function ($) {
    "use strict";
  
    var ChartJs = function ChartJs() {};
  
    ChartJs.prototype.respChart = function (selector, type, data, options) {
      Chart.defaults.global.defaultFontColor = "#8791af", Chart.defaults.scale.gridLines.color = "rgba(166, 176, 207, 0.1)"; // get selector by context
  
      var ctx = selector.get(0).getContext("2d"); // pointing parent container to make chart js inherit its width
  
      var container = $(selector).parent(); // enable resizing matter
  
      // $(window).resize(generateChart); // this function produce the responsive Chart JS
  
      function generateChart() {
        // make chart width fit with its container
        var ww = selector.attr('width', $(container).width());
  
        switch (type) {
          case 'Line':
            new Chart(ctx, {
              type: 'line',
              data: data,
              options: options
            });
            break;
  
          case 'Doughnut':
            new Chart(ctx, {
              type: 'doughnut',
              data: data,
              options: options
            });
            break;
  
          case 'Pie':
            new Chart(ctx, {
              type: 'pie',
              data: data,
              options: options
            });
            break;
  
          case 'Bar':
            new Chart(ctx, {
              type: 'bar',
              data: data,
              options: options
            });
            break;
  
          case 'Radar':
            new Chart(ctx, {
              type: 'radar',
              data: data,
              options: options
            });
            break;
  
          case 'PolarArea':
            new Chart(ctx, {
              data: data,
              type: 'polarArea',
              options: options
            });
            break;
        } // Initiate new chart or Redraw
  
      }
  
      ; // run function - render chart at first load
  
      generateChart();
    }, //init
    ChartJs.prototype.init = function () {

      var pie_inm_gs = {
        labels: ["Al Dia", "Mora"],
        datasets: [{
          data: [scigs.value, svigs.value],
          backgroundColor: ["#3483c3", "#db0909"],
          hoverBackgroundColor: ["#3483c3", "#db0909"],
          hoverBorderColor: "#fff"
        }]
      };
      this.respChart($("#pie_inm_gs"), 'Pie', pie_inm_gs); //Inmuebles GS

      var pie_inm_us = {
        labels: ["Al Dia", "Mora"],
        datasets: [{
          data: [scius.value, svius.value],
          backgroundColor: ["#3483c3", "#db0909"],
          hoverBackgroundColor: ["#3483c3", "#db0909"],
          hoverBorderColor: "#fff"
        }]
      };
      this.respChart($("#pie_inm_us"), 'Pie', pie_inm_us); //Inmuebles US

      var pie_mue_gs = {
        llabels: ["Al Dia", "Mora"],
        datasets: [{
          data: [scmgs.value, svmgs.value],
          backgroundColor: ["#3483c3", "#db0909"],
          hoverBackgroundColor: ["#3483c3", "#db0909"],
          hoverBorderColor: "#fff"
        }]
      };
      this.respChart($("#pie_mue_gs"), 'Pie', pie_mue_gs); //Vehiculos GS

      var pie_mue_us = {
        labels: ["Al Dia", "Mora"],
        datasets: [{
          data: [scmus.value, svmus.value],
          backgroundColor: ["#3483c3", "#db0909"],
          hoverBackgroundColor: ["#3483c3", "#db0909"],
          hoverBorderColor: "#fff"
        }]
      };
      this.respChart($("#pie_mue_us"), 'Pie', pie_mue_us); //Vehiculos GS


      var pie_acu_gs = {
        labels: ["Al Dia "+scags.value, "Mora"],
        datasets: [{
          data: [scags.value, svags.value],
          backgroundColor: ["#3483c3", "#db0909"],
          hoverBackgroundColor: ["#3483c3", "#db0909"],
          hoverBorderColor: "#fff"
        }]
      };
      this.respChart($("#pie_acu_gs"), 'Pie', pie_acu_gs); //Acuerdos GS

      var pie_acu_us = {
        labels: ["Al Dia", "Mora"],
        datasets: [{
          data: [scaus.value, svaus.value],
          backgroundColor: ["#3483c3", "#db0909"],
          hoverBackgroundColor: ["#3483c3", "#db0909"],
          hoverBorderColor: "#fff"
        }]
      };
      this.respChart($("#pie_acu_us"), 'Pie', pie_acu_us); //Acuerdos GS

  

    }, $.ChartJs = new ChartJs(), $.ChartJs.Constructor = ChartJs;
  }(window.jQuery), //initializing
  function ($) {
    "use strict";
  
    $.ChartJs.init();
  }(window.jQuery);
  /******/ })()
  ;

