const gjsAnimation = (editor) => {
	// Update default link component
  const comps = editor.DomComponents;

  const containerType = comps.getType("container");
  const containerModel = containerType.model;

  editor.DomComponents.addType("container", {
    model: containerModel.extend({
      defaults: Object.assign({}, containerModel.prototype.defaults, {
        traits: [
          {
              type: "animation",
              label: "Animation",
              name: "animation",
          },
          {
              type: "duration",
              label: "Duration(s)",
              name: "duration",
          },
          {
              type: "delay",
              label: "Delay(s)",
              name: "delay",
          },
        ].concat(containerModel.prototype.defaults.traits),
      }),
    }),
  });

  const columnType = comps.getType("column");
  const columnModel = columnType.model;

  editor.DomComponents.addType("column", {
    model: columnModel.extend({
      defaults: Object.assign({}, columnModel.prototype.defaults, {
        traits: [
          {
              type: "animation",
              label: "Animation",
              name: "animation",
          },
          {
              type: "duration",
              label: "Duration(s)",
              name: "duration",
          },
          {
              type: "delay",
              label: "Delay(s)",
              name: "delay",
          },
        ].concat(columnModel.prototype.defaults.traits),
      }),
    }),
  });

  editor.TraitManager.addType("animation", {
      createLabel({ label }) {
          return `<div>
          ${label}
          </div>`;
      },
      createInput({ trait }) {
          const traitOpts = trait.get("options") || [];
          const options = traitOpts.length
              ? traitOpts
              : [
                    { id: "", name: "None" },
                    { id: "bounce", name: "Bounce" },
                    { id: "fadeIn", name: "Fade In" },
                ];

          const el = document.createElement("div");
          el.innerHTML = `
      <select class="animation__type">
        ${options
            .map((opt) => `<option value="${opt.id}">${opt.name}</option>`)
            .join("")}
      </select>
      <div class="gjs-sel-arrow">
        <div class="gjs-d-s-arrow"></div>
      </div>`;

          return el;
      },
      onEvent({ elInput, component }) {
          const inputType = elInput.querySelector(".animation__type");
          let dataAnimate = inputType.value;

          if (dataAnimate === "") {
              $("#traits-mgr .gjs-trt-trait__wrp-duration").hide();
              $("#traits-mgr .gjs-trt-trait__wrp-delay").hide();
              component.removeAttributes("data-animate");
              $("#traits-mgr .gjs-trt-trait__wrp-duration").find("input").val(0);
              $("#traits-mgr .gjs-trt-trait__wrp-delay").find("input").val(0);
              component.removeClass(component._previousAttributes.attributes["data-animate"] + " animated");
              component.removeStyle("animation-duration");
              component.removeStyle("animation-delay");
          } else {
              $("#traits-mgr .gjs-trt-trait__wrp-duration").show();
              $("#traits-mgr .gjs-trt-trait__wrp-delay").show();
              component.addAttributes({ "data-animate": dataAnimate });
              component.removeClass(component._previousAttributes.attributes["data-animate"] + " animated");
              component.addClass(dataAnimate + " animated");
          }
      },
      onUpdate({ elInput, component, trait }) {
          const dataAnimate = component.getAttributes()["data-animate"] || "";

          elInput.querySelector(".animation__type").value = dataAnimate;
          if(dataAnimate === "") {
            setTimeout(function() {
              $("#traits-mgr .gjs-trt-trait__wrp-duration").hide();
              $("#traits-mgr .gjs-trt-trait__wrp-delay").hide();
            }, 500);
          }
      },
  });

  editor.TraitManager.addType("duration", {
      events:{
        'change': 'onChange',
      },
      createLabel({ label }) {
          return `<div>
          ${label}
        </div>`;
      },
      createInput({ trait }) {
          const traitGet = trait.get("input") || [];

          const el = document.createElement("div");
          el.className = "gjs-quantity";
          el.innerHTML = `
      <input type="number" class="duration__type" value="${traitGet}" min="0" max="9" onKeyPress="if(this.value.length==1) return false;">
      <div class="gjs-field-arrows gjs-arrows">
        <div class="gjs-field-arrow-u gjs-arrow-u"></div>
        <div class="gjs-field-arrow-d gjs-arrow-d"></div>
      </div>
      `;
  
	

          return el;
      },
      onEvent({ elInput, component }) {
          const inputType = elInput.querySelector(".duration__type");
          let dataDuration = inputType.value;
          let dataAnimate = $("#traits-mgr .gjs-trt-trait__wrp-animation").find("select").val();

          if (dataDuration == 0) {
              component.removeStyle("animation-duration");
              component.removeClass(dataAnimate + " animated");
              component.addClass(dataAnimate + " animated");
          } else {
              component.addStyle({ "animation-duration": dataDuration + "s" });
              component.removeClass(dataAnimate + " animated");
              component.addClass(dataAnimate + " animated");
          }
          $("#styles").val(editor.getCss());
      },
      onchange({ elInput, component }) {
          const inputType = elInput.querySelector(".duration__type");
          let dataDuration = inputType.value;
          let dataAnimate = $("#traits-mgr .gjs-trt-trait__wrp-animation").find("select").val();

          if (dataDuration == 0) {
              component.removeStyle("animation-duration");
              component.removeClass(dataAnimate + " animated");
              component.addClass(dataAnimate + " animated");
          } else {
              component.addStyle({ "animation-duration": dataDuration + "s" });
              component.removeClass(dataAnimate + " animated");
              component.addClass(dataAnimate + " animated");
          }
          $("#styles").val(editor.getCss());
      },
      onUpdate({ elInput, component }) {
          let comp = this;
          const dataDuration = component.getStyle()["animation-duration"] || "";

          elInput.querySelector(".duration__type").value = dataDuration.replace(/s/, "");

          setTimeout(function() {
              var spinner = $(".gjs-field-duration .gjs-quantity"),
              input = spinner.find('input[type="number"]'),
              btnUp = spinner.find(".gjs-field-arrow-u.gjs-arrow-u"),
              btnDown = spinner.find(".gjs-field-arrow-d.gjs-arrow-d"),
              min = input.attr("min"),
              max = input.attr("max");

            btnUp.on("click", function () {
              var oldValue = parseFloat(input.val());
              if (oldValue >= max) {
                var newVal = oldValue;
              } else {
                var newVal = oldValue + 1;
              }
              spinner.find("input").val(newVal);
              comp.onChange();
            });

            btnDown.on("click", function () {
              var oldValue = parseFloat(input.val());
              if (oldValue <= min) {
                var newVal = oldValue;
              } else {
                var newVal = oldValue - 1;
              }
              spinner.find("input").val(newVal);
              comp.onChange();
            });

            $("#traits-mgr .gjs-trt-trait__wrp-duration").find("input").keyup(function () {
                comp.onChange();
            });
          }, 1000)
      },
  });

  editor.TraitManager.addType("delay", {
      events:{
        'change': 'onChange',
      },
      createLabel({ label }) {
          return `<div>
          ${label}
        </div>`;
      },
      createInput({ trait }) {
          const traitGet = trait.get("input") || [];

          const el = document.createElement("div");
          el.className = "gjs-quantity";
          el.innerHTML = `
      <input type="number" class="delay__type" value="${traitGet}" min="0" max="9" onKeyPress="if(this.value.length==1) return false;">
      <div class="gjs-field-arrows gjs-arrows">
        <div class="gjs-field-arrow-u gjs-arrow-u"></div>
        <div class="gjs-field-arrow-d gjs-arrow-d"></div>
      </div>
      `;
  
	

          return el;
      },
      onEvent({ elInput, component }) {
          const inputType = elInput.querySelector(".delay__type");
          let dataDelay = inputType.value;
          let dataAnimate = $("#traits-mgr .gjs-trt-trait__wrp-animation").find("select").val();

          if (dataDelay == 0) {
              component.removeStyle("animation-delay");
              component.removeClass(dataAnimate + " animated");
              component.addClass(dataAnimate + " animated");
          } else {
              component.addStyle({ "animation-delay": dataDelay + "s" });
              component.removeClass(dataAnimate + " animated");
              component.addClass(dataAnimate + " animated");
          }
          $("#styles").val(editor.getCss());
      },
      onUpdate({ elInput, component }) {
          let comp = this;
          const dataDelay = component.getStyle()["animation-delay"] || "";

          elInput.querySelector(".delay__type").value = dataDelay.replace(/s/, "");

          setTimeout(function() {
              var spinner = $(".gjs-field-delay .gjs-quantity"),
              input = spinner.find('input[type="number"]'),
              btnUp = spinner.find(".gjs-field-arrow-u.gjs-arrow-u"),
              btnDown = spinner.find(".gjs-field-arrow-d.gjs-arrow-d"),
              min = input.attr("min"),
              max = input.attr("max");

            btnUp.on("click", function () {
              var oldValue = parseFloat(input.val());
              if (oldValue >= max) {
                var newVal = oldValue;
              } else {
                var newVal = oldValue + 1;
              }
              spinner.find("input").val(newVal);
              comp.onChange();
            });

            btnDown.on("click", function () {
              var oldValue = parseFloat(input.val());
              if (oldValue <= min) {
                var newVal = oldValue;
              } else {
                var newVal = oldValue - 1;
              }
              spinner.find("input").val(newVal);
              comp.onChange();
            });

            $("#traits-mgr .gjs-trt-trait__wrp-delay").find("input").keyup(function () {
                comp.onChange();
            });
          }, 1000)
      },
  });

};