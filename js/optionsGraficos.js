var optionsChartfrecuenciaCategorias= {
    plugins: {
            title: {
                display: true,
                text: 'Frecuencia vs TipoTrabajo'
            }
          },
          scales: {
            yAxes: {
                title: {
                  display: true,
                  text: 'Frecuencia'
                },
                ticks: {
                   stepSize: 1,
                }
            },
            xAxes: {
                title: {
                  display: true,
                  text: 'TipoTrabajo'
                }
            }
          }
  }
  var optionsChartcostoMaterialesCategorias ={
        plugins: {
          title: {
              display: true,
              text: 'CostoMaterial vs TipoTrabajo'
          }
        },
        scales: {
          yAxes: {
              title: {
                display: true,
                text: 'CostoMaterial'
              },
              ticks: {
                 stepSize: 1,
              }
          },
          xAxes: {
              title: {
                display: true,
                text: 'TipoTrabajo'
              },
          }
        }
  }

  var optionsChartcostoFuncionariosEjecutivosCategorias = {
    plugins: {
        title: {
            display: true,
            text: 'CostoFuncionarios vs TipoTrabajo'
        }
      },
      scales: {
        yAxes: {
            title: {
              display: true,
              text: 'CostoFuncionarios'
            },
            ticks: {
               stepSize: 1,
            }
        },
        xAxes: {
            title: {
              display: true,
              text: 'TipoTrabajo'
            },
        }
      }
  }

  var optionsChartcostoTotalCategorias = {
    plugins: {
        title: {
            display: true,
            text: 'CostoTotal vs TipoTrabajo'
        }
      },
      scales: {
        yAxes: {
            title: {
              display: true,
              text: 'CostoTotal'
            },
            ticks: {
               stepSize: 1,
            }
        },
        xAxes: {
            title: {
              display: true,
              text: 'TipoTrabajo'
            },
        }
      }
  }

  var optionsChartfrecuenciaOrdenesPorHoras = {
    plugins: {
        title: {
            display: true,
            text: 'Frecuencia vs HorasOrden'
        }
      },
      scales: {
    
        y: {
          min: 0,
          ticks: {
              stepSize: 1
          }
        },
        xAxes: {
            title: {
              display: true,
              text: 'HorasOrden'
            },
        }
      }
  }