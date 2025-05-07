(function () {
  const init = () => {
    const domElements = {
      openFloatingCart: document.querySelector(".open-floating-cart"),
      closeFloatingCart: document.querySelector(".close-floating-cart"),
      addTocartButton: document.querySelectorAll(".single_add_to_cart_button"),
      floatingCart: document.querySelector(".floating-cart"),
      hamburger: document.querySelector(".hamburger"),
      megaMenu: document.querySelector(".mega-menu"),
      closeMegaMenu: document.querySelector(".close-mega-menu"),
      navigationBox: document.getElementById("navigation-box"),
      megaMenuGoBack: document.getElementById("mega-menu-go-back"),
      megaMenuContainer: document.querySelector(".mega-menu-nav"),
      categoryFilterLinks: document.querySelectorAll(".category-filter-link"),
      megaMenuGoBack: document.getElementById("mega-menu-go-back"),
      decreaseQuantity: document.querySelector(".decrease_quantity"),
      increaseQuantity: document.querySelector(".increase_quantity"),
      sortProducts: document.getElementById("sort_products"),
      filterCheckboxes: document.querySelectorAll(".filter-checkbox"),
      filterBoxes: document.querySelectorAll(".filters-box"),
      loadMoreProducts: document.querySelector("#load-more-products"),
      clearAllFilters: document.querySelector(".clear-all-filters"),
      clearFilters: document.querySelectorAll(".clear-filter"),
      openModalFilters: document.querySelector(".open-filters"),
      closeModalFilters: document.querySelector(".close-filters-container"),
      closeFiltersButton: document.querySelector(".close-filters-button"),
      searchBoxContainer: document.getElementById("search-box-container"),
      searchProductsInput: document.getElementById("search-products"),
      resultsBox: document.getElementById("search-results-box"),
      results: document.getElementById("products-list"),
      termsList: document.getElementById("search-terms-list"),
      searchHistory: document.getElementById("search-history"),
      closeSearch: document.querySelector(".close-search"),
      triggerSearch: document.querySelector("#trigger-search"),
      searchModal: document.querySelector("#search-modal"),
      triggerImagesLightBox: document.querySelectorAll(".trigger-lightbox"),
      closeLightBox: document.querySelector(".close-lightbox"),
      lightboxModal: document.querySelector("#lightbox"),
    };

    const disableScroll = () => {
      document.body.style.overflow = "hidden";
      if (window.innerWidth > 400) {
        document.body.style.paddingRight = "0.25rem";
      } else {
        document.body.style.paddingRight = "0rem";
      }
    };
    const enableScroll = () => {
      document.body.style.overflow = "auto";
      document.body.style.paddingRight = "0rem";
    };

    // variable
    let VIDEO_MOBILE_PLAYING_STATE = {
      PLAYING: "PLAYING",
      PAUSE: "PAUSE",
    };

    let videoMobilePlayStatus = VIDEO_MOBILE_PLAYING_STATE.PAUSE;
    let mobileTimeout = null;

    let swiperMobile = new Swiper(".product-images-gallery", {
      loop: true,
      spaceBetween: 32,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });

    let mobilePlayer = document.getElementById("video-player-mobile");
    if (mobilePlayer) {
      const customHandler = () => {
        let index = swiperMobile.activeIndex;
        let currentSlide = swiperMobile.slides[index];
        let currentSlideType = currentSlide.dataset.slide_type;

        if (videoMobilePlayStatus === VIDEO_MOBILE_PLAYING_STATE.PLAYING) {
          mobilePlayer.pause();
        }

        clearTimeout(mobileTimeout);

        switch (currentSlideType) {
          case "image":
            break;
          case "video":
            mobilePlayer.currentTime = 0;
            mobilePlayer.play();
            videoMobilePlayStatus = VIDEO_MOBILE_PLAYING_STATE.PLAYING;
            break;
          default:
            throw new Error("invalid slide type");
        }
      };

      swiperMobile.on("slideChangeTransitionEnd", function () {
        customHandler();
      });
    }

    let slides = document.querySelectorAll(".zoom-mobile");

    if (slides.length > 0) {
      slides.forEach((slide) => {
        slide.addEventListener("click", (e) => {
          let zoomer = e.target.parentElement;
          let swiperButtons = document.querySelectorAll(
            ".swiper-button-mobile"
          );

          if (zoomer.classList.contains("touched")) {
            zoomer.classList.remove("touched");
            swiperMobile.attachEvents();
            enableScroll();
            zoomer.style.transform = "scale(1)";
            e.target.style.opacity = 1;
            if (swiperButtons.length > 0) {
              swiperButtons.forEach((b) => {
                b.style.display = "block";
              });
            }
          } else {
            swiperMobile.detachEvents();
            disableScroll();

            e.target.style.opacity = 0;
            zoomer.classList.add("touched");
            zoomer.style.backgroundSize = "100%";
            zoomer.style.transform = "scale(3.5)";
            zoomer.style.width = "100%";
            if (swiperButtons.length > 0) {
              swiperButtons.forEach((b) => {
                b.style.display = "none";
              });
            }
          }
        });

        let touchStart = { x: 0, y: 0 };
        let touchDistance = { x: 0, y: 0 };
        let touchFinishDistance = { x: 0, y: 0 };

        slide.addEventListener("touchstart", (e) => {
          touchStart = { x: e.touches[0].clientX, y: e.touches[0].clientY };
          touchDistance = { x: 0, y: 0 };
        });

        slide.addEventListener("touchend", (e) => {
          let zoomer = e.target.parentElement;
          let values = null;
          if (zoomer) {
            values = zoomer.style.transform.split(/\w+\(|\);?/);
          }

          touchFinishDistance = {
            x:
              values.length > 3
                ? +values[3].split(/,\s?/g)[0].replace("px", "")
                : 0,
            y:
              values.length > 3
                ? +values[3].split(/,\s?/g)[1].replace("px", "")
                : 0,
          };
        });

        slide.addEventListener("touchmove", (e) => {
          let zoomer = e.target.parentElement;
          if (zoomer.classList.contains("touched")) {
            e.preventDefault();
            disableScroll();
            swiperMobile.detachEvents();

            touchDistance = {
              x: e.touches[0].clientX - touchStart.x,
              y: e.touches[0].clientY - touchStart.y,
            };

            let x = touchFinishDistance.x + touchDistance.x / 2;
            let y = touchFinishDistance.y + touchDistance.y / 2;

            let finalX = 0;
            let finalY = 0;
            if (x > zoomer.parentElement.getBoundingClientRect().width - 200) {
              finalX = zoomer.parentElement.getBoundingClientRect().width - 200;
            } else if (
              x <
              -zoomer.parentElement.getBoundingClientRect().width + 200
            ) {
              finalX =
                -zoomer.parentElement.getBoundingClientRect().width + 200;
            } else {
              finalX = x;
            }

            if (y > zoomer.parentElement.getBoundingClientRect().height - 250) {
              finalY =
                zoomer.parentElement.getBoundingClientRect().height - 250;
            } else if (
              y <
              -zoomer.parentElement.getBoundingClientRect().height + 250
            ) {
              finalY =
                -zoomer.parentElement.getBoundingClientRect().height + 250;
            } else {
              finalY = y;
            }

            zoomer.style.transform = `scale(3.5) translate(${finalX}px, ${finalY}px)`;
          }
        });
      });
    }

    const closeCart = () => {
      domElements.floatingCart.style.visibility = "hidden";
      domElements.floatingCart.children[0].style.opacity = "0";
      domElements.floatingCart.children[1].style.transform = "translateX(100%)";
      enableScroll();
      setTimeout(() => {
        domElements.floatingCart.children[1].replaceWith(
          domElements.floatingCart.children[1].cloneNode(true)
        );
        let closeCartBtn = document.querySelectorAll(".close-floating-cart");
        closeCartBtn.forEach((item) => {
          item.addEventListener("click", () => {
            closeCart(domElements.floatingCart);
          });
        });
      }, 200);
    };

    if (domElements.triggerImagesLightBox) {
      domElements.triggerImagesLightBox.forEach((ti) => {
        ti.addEventListener("click", () => {
          domElements.lightboxModal.classList.add("opened");
          disableScroll();
        });
      });
    }

    if (domElements.closeLightBox) {
      if (domElements.lightboxModal) {
        domElements.closeLightBox.addEventListener("click", () => {
          if (domElements.lightboxModal.classList.contains("opened")) {
            domElements.lightboxModal.classList.remove("opened");
            enableScroll();
          }
        });
      }
    }

    if (domElements.triggerSearch) {
      if (domElements.searchModal) {
        domElements.triggerSearch.addEventListener("click", () => {
          if (!domElements.searchModal.classList.contains("opened")) {
            domElements.searchModal.classList.add("opened");
            disableScroll();
          }
        });
      }
    }
    if (domElements.closeSearch) {
      if (domElements.searchModal) {
        domElements.closeSearch.addEventListener("click", () => {
          if (domElements.searchModal.classList.contains("opened")) {
            domElements.searchModal.classList.remove("opened");
            enableScroll();
          }
        });
      }
    }

    const removeItemFromCart = async (product_id) => {
      let data = {
        action: "woocommerce_ajax_remove_from_cart",
      };
      data.product_id = product_id;
      try {
        let res = await fetch(`${woocommerce_scritps_helper.ajaxurl}`, {
          credentials: "same-origin",
          method: "POST",
          body: new URLSearchParams({ ...data }),
        });

        const updatedCart = await res.json();

        let cartCounter = document.querySelector(".shop-cart-counter");
        let cartCounterUpdated = new DOMParser().parseFromString(
          updatedCart.fragments[".shop-cart-counter"],
          "text/xml"
        );
        cartCounter.innerHTML = cartCounterUpdated.childNodes[0].innerHTML;

        let cartContent = document.querySelector(".cart-container");
        let cartContentUpdated = new DOMParser().parseFromString(
          updatedCart.fragments[".cart-container"],
          "text/html"
        );

        cartContent.innerHTML =
          cartContentUpdated.children[0].children[1].children[0].innerHTML;
        // setTimeout(() => {
        //   openCart();
        // }, 100);
      } catch (error) {
        console.log(error);
      }
    };

    const modalRemoveItemFromCart = async (product_id) => {
      let data = {
        action: "woocommerce_ajax_remove_from_cart_confirmation",
      };
      data.product_id = product_id;
      try {
        const res = await fetch(`${woocommerce_scritps_helper.ajaxurl}`, {
          method: "POST",
          mode: "cors",
          body: new URLSearchParams({ ...data }),
        });
        const response = await res.text();
        domElements.floatingCart.children[1].style.transform =
          "translateX(100%)";
        let modalConfirmation = new DOMParser().parseFromString(
          response,
          "text/html"
        ).children[0].children[1].children[0];

        let body = domElements.floatingCart;
        modalConfirmation.children[1].children[0].children[0].addEventListener(
          "click",
          (e) => {
            e.preventDefault();
            body.removeChild(modalConfirmation);
            closeCart();
          }
        );
        modalConfirmation.children[1].children[2].children[0].addEventListener(
          "click",
          (e) => {
            e.preventDefault();
            body.removeChild(modalConfirmation);
            closeCart();
          }
        );
        modalConfirmation.children[1].children[2].children[1].addEventListener(
          "click",
          (e) => {
            e.preventDefault();
            removeItemFromCart(product_id);
            body.removeChild(modalConfirmation);
            closeCart();
          }
        );
        domElements.floatingCart.children[1].style.transform =
          "translateX(100%)";
        body.appendChild(modalConfirmation);

        setTimeout(() => {
          modalConfirmation.children[1].style.opacity = 1;
          modalConfirmation.children[1].style.transform = "translateY(0px)";
          modalConfirmation.children[0].addEventListener("click", (e) => {
            body.removeChild(modalConfirmation);
            closeCart();
          });
        }, 50);
      } catch (error) {
        console.log(error);
      }
    };

    const openCart = () => {
      domElements.floatingCart.style.visibility = "visible";
      domElements.floatingCart.children[0].style.opacity = "1";
      domElements.floatingCart.children[0].addEventListener("click", () => {
        closeCart();
      });
      domElements.floatingCart.children[1].style.transform = "translateX(0px)";

      let allRemoveItems = document.querySelectorAll(".remove_item_from_cart");

      allRemoveItems.forEach((it) => {
        it.addEventListener("click", async (e) => {
          e.preventDefault();
          await modalRemoveItemFromCart(it.dataset.product_id);
        });
      });

      let closeCartBtn = document.querySelectorAll(".close-floating-cart");
      closeCartBtn.forEach((item) => {
        item.addEventListener("click", () => {
          closeCart(domElements.floatingCart);
        });
      });
      disableScroll();
    };

    domElements.openFloatingCart.addEventListener("click", () => {
      openCart();
    });

    if (domElements.addTocartButton) {
      domElements.addTocartButton.forEach((addToCart) => {
        addToCart.addEventListener("click", async function (evnt) {
          evnt.preventDefault();
          let data = {
            action: "woocommerce_ajax_add_to_cart",
          };
          data.quantity = addToCart.parentNode.querySelector(
            "input[name='quantity']"
          )?.value
            ? addToCart.parentNode.querySelector("input[name='quantity']").value
            : 1;
          data.product_id = addToCart.value
            ? addToCart.value
            : addToCart.parentNode.querySelector("input[name='product_id']")
                .value;
          data.variation_id = addToCart.parentNode.querySelector(
            "input[name='variation_id']"
          )?.value
            ? addToCart.parentNode.querySelector("input[name='variation_id']")
                .value
            : null;

          try {
            let res = await fetch(`${woocommerce_scritps_helper.ajaxurl}`, {
              credentials: "same-origin",
              method: "POST",
              body: new URLSearchParams({ ...data }),
            });
            const updatedCart = await res.json();
            let cartCounter = document.querySelector(".shop-cart-counter");
            let cartCounterUpdated = new DOMParser().parseFromString(
              updatedCart.fragments[".shop-cart-counter"],
              "text/xml"
            );
            cartCounter.innerHTML = cartCounterUpdated.childNodes[0].innerHTML;
            let cartContent = document.querySelector(".cart-container");
            let cartContentUpdated = new DOMParser().parseFromString(
              updatedCart.fragments[".cart-container"],
              "text/html"
            );
            cartContent.innerHTML =
              cartContentUpdated.children[0].children[1].children[0].innerHTML;
            setTimeout(() => {
              openCart();
              // addToCart.parentNode.querySelector(
              //   "input[name='quantity']"
              // ).value = 1;
            }, 100);
            if (data.variation_id) {
              let currentSelected =
                addToCart.parentNode.querySelector(".current_selected");
              currentSelected.innerHTML = "define";
              addToCart.parentNode.querySelector(
                "input[name='variation_id']"
              ).value = "0";
              addToCart.classList.add("disabled");
              addToCart.classList.add("wc-variation-selection-needed");
            }
          } catch (error) {
            console.log(error);
          }
        });
      });
    }

    const tamanhoOptions = document.querySelectorAll(".tamanho_option");
    if (tamanhoOptions) {
      tamanhoOptions.forEach((option) => {
        option.addEventListener("click", (e) => {
          e.preventDefault();
          if (parseInt(option.dataset.stock) <= 0) {
            return;
          }
          tamanhoOptions.forEach((item) => {
            item.classList.remove("btn-quad-selected");
          });
          let variationAlert = document.querySelector(".variation-alert");
          variationAlert.style.opacity = 0;

          let variation_input = document.querySelector(
            "input[name='variation_id']"
          );
          variation_input.value = option.getAttribute("data-value");

          if (!option.classList.contains("btn-quad-selected")) {
            option.classList.add("btn-quad-selected");
          }
        });
      });
    }

    let addTocartButton = document.querySelector(
      ".variation_add_to_cart_button"
    );
    if (addTocartButton) {
      addTocartButton.addEventListener("click", async function (evnt) {
        evnt.preventDefault();
        let data = {
          action: "woocommerce_ajax_add_to_cart",
        };
        data.product_qty = 1;
        data.product_id = addTocartButton.value
          ? addTocartButton.value
          : document.querySelector("input[name='product_id']").value;

        data.variation_id = document.querySelector("input[name='variation_id']")
          ?.value
          ? document.querySelector("input[name='variation_id']").value
          : null;
        let variationAlert = document.querySelector(".variation-alert");
        if (data.variation_id === "0" || data.variation_id === "") {
          variationAlert.style.opacity = 1;
          return;
        }

        try {
          let res = await fetch(`${woocommerce_scritps_helper.ajaxurl}`, {
            credentials: "same-origin",
            method: "POST",
            body: new URLSearchParams({ ...data }),
          });
          const updatedCart = await res.json();
          let cartCounter = document.querySelector(".shop-cart-counter");
          let cartCounterUpdated = new DOMParser().parseFromString(
            updatedCart.fragments[".shop-cart-counter"],
            "text/xml"
          );
          cartCounter.innerHTML = cartCounterUpdated.childNodes[0].innerHTML;
          let cartContent = document.querySelector(".cart-container");
          let cartContentUpdated = new DOMParser().parseFromString(
            updatedCart.fragments[".cart-container"],
            "text/html"
          );
          cartContent.innerHTML =
            cartContentUpdated.children[0].children[1].children[0].innerHTML;

          if (data.variation_id) {
            document.querySelector("input[name='variation_id']").value = "0";
            addTocartButton.classList.add("disabled");
            addTocartButton.classList.add("wc-variation-selection-needed");
          }
          const tamanhoOptions = document.querySelectorAll(".tamanho_option");
          if (tamanhoOptions) {
            tamanhoOptions.forEach((item) => {
              item.classList.remove("btn-quad-selected");
            });
          }
          setTimeout(() => {
            openCart();
          }, 100);
        } catch (error) {
          console.log(error);
        }
      });
    }

    //////////////////////////////// MEGA MENU ////////////////////////////////

    const closeMenu = () => {
      domElements.megaMenu.style.visibility = "hidden";
      domElements.megaMenu.children[0].style.opacity = 0;
      domElements.megaMenu.children[1].style.transform = "translateX(-100%)";
      enableScroll();
    };

    if (domElements.hamburger) {
      domElements.hamburger.addEventListener("click", () => {
        domElements.megaMenu.style.visibility = "visible";
        domElements.megaMenu.children[0].style.opacity = 1;
        domElements.megaMenu.children[1].style.transform = "translateX(0px)";
        domElements.megaMenu.children[0].addEventListener("click", () => {
          closeMenu();
        });
        disableScroll();
      });
    }

    if (domElements.closeMegaMenu) {
      domElements.closeMegaMenu.addEventListener("click", () => {
        closeMenu();
      });
    }

    if (domElements.categoryFilterLinks) {
      domElements.categoryFilterLinks.forEach((link) => {
        link.addEventListener("click", (e) => {
          const menuToOpen = document.getElementById(link.dataset.openmenu);
          if (menuToOpen) {
            domElements.navigationBox.classList.remove("showNav");
            domElements.navigationBox.style.opacity = 0;
            domElements.navigationBox.style.visibility = "hidden";
            menuToOpen.style.opacity = 1;
            menuToOpen.style.visibility = "visible";
            menuToOpen.children[0].style.display = "block";
            menuToOpen.children[0].classList.add("showSubNav");
            domElements.megaMenuGoBack.style.opacity = 1;
            // navLogo.style.transform = "translateX(10px)";
            domElements.megaMenuContainer.style.transform = "translateX(10px)";
          }
        });
      });
    }

    const resetMenu = () => {
      const subMenus = document.querySelectorAll(".second-menu");
      if (subMenus) {
        subMenus.forEach((e) => {
          e.style.visibility = "hidden";
          e.style.opacity = 0;
          domElements.megaMenuGoBack.style.opacity = 0;
          domElements.navigationBox.style.opacity = 1;
          domElements.navigationBox.style.visibility = "visible";
          e.children[0].style.display = "none";
          e.children[0].classList.remove("showSubNav");
          domElements.megaMenuContainer.style.transform = "translateX(0px)";
        });
      }
    };

    if (domElements.megaMenuGoBack) {
      domElements.megaMenuGoBack.addEventListener("click", (e) => {
        domElements.navigationBox.classList.add("showNav");
        resetMenu();
      });
    }
  };

  function dataFormatada(date) {
    var data = new Date(date),
      dia = data.getDate().toString().padStart(2, "0"),
      mes = (data.getMonth() + 1).toString().padStart(2, "0"), //+1 pois no getMonth Janeiro começa com zero.
      ano = data.getFullYear();
    return ano + "-" + mes + "-" + dia;
  }

  const newsletterForm = document.getElementById("newsletter");
  if (newsletterForm) {
    newsletterForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const status = document.getElementById("newsletter_sub_status");
      let dados = [...newsletterForm.getElementsByTagName("input")];
      let btn = newsletterForm.getElementsByTagName("button")[0];

      let dataToSend = {
        base: {
          consent: "any",
          status: "active",
        },
      };

      dados.forEach((input) => {
        if (input.type === "text" || input.type === "email") {
          let value = input.value;
          let name = input.name;
          let dataInput = input.getAttribute("data-input-id");

          if (!dataInput) {
            dataToSend.base[name] = value;
          } else {
            extra.push({
              field_id: dataInput,
              value: value,
            });
          }
        } else if (input.type === "date") {
          let value = dataFormatada(input.value);
          let name = input.name;
          let dataInput = input.getAttribute("data-input-id");

          if (!dataInput) {
            dataToSend.base[name] = value;
          } else {
            extra.push({
              field_id: dataInput,
              value: value,
            });
          }
        }
      });

      let data = {
        action: "subscribe_to_egoi_newsletter",
        data: JSON.stringify(dataToSend),
      };

      btn.classList.add("submitting");
      btn.disabled = true;
      let previousInnerHtml = btn.innerHTML;
      btn.innerHTML =
        '<div role="status">\
          <svg class="inline w-4 h-4 text-white animate-spin fill-primary" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">\
              <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>\
              <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>\
          </svg>\
          <span class="sr-only">Loading...</span>\
      </div>';

      try {
        const res = await fetch(`${woocommerce_scritps_helper.ajaxurl}`, {
          credentials: "same-origin",
          method: "POST",
          body: new URLSearchParams({ ...data }),
        });

        let response = await res.json();

        if (response === 201) {
          status.style.color = "#22c55e";
          status.innerHTML = "Subscrição efectuada com sucesso.";
          // status.style.maxHeight = "200px";

          // setTimeout(() => {
          //   status.style.maxHeight = "0px";
          // }, 5000);
        } else if (response === 409) {
          status.style.color = "#E54235";
          status.innerHTML =
            "O seu email já se encontra na nossa lista. Subscreva a newsletter com outro email.";
          // status.style.maxHeight = "200px";

          // setTimeout(() => {
          //   status.style.maxHeight = "0px";
          // }, 5000);
        } else {
          status.style.color = "#E54235";
          status.innerHTML = "Erro a adicionar o email a nossa lista!";
          // status.style.maxHeight = "200px";

          // setTimeout(() => {
          //   status.style.maxHeight = "0px";
          // }, 5000);
        }

        btn.classList.remove("submitting");
        btn.disabled = false;
        btn.innerHTML = previousInnerHtml;
      } catch (error) {
        console.log(error);
        status.style.color = "#E54235";
        status.innerHTML = error;
        // status.style.maxHeight = "200px";

        // setTimeout(() => {
        //   status.style.maxHeight = "0px";
        // }, 5000);
        btn.classList.remove("submitting");
        btn.disabled = false;
        btn.innerHTML = previousInnerHtml;
      }
    });
  }

  setTimeout(() => {
    let swiper_thumbs = document.querySelector(".swiper.thumbsSwipper");
    if (swiper_thumbs) {
      let items = swiper_thumbs.children[0].querySelectorAll(".swiper-slide");
      let parentHeight = swiper_thumbs.getBoundingClientRect().height;
      let height = 0;
      items.forEach((i) => {
        height = height + 10 + i.getBoundingClientRect().height;
      });
      let y = (parentHeight - height) / 2;
      if (y >= 0) {
        swiper_thumbs.children[0].style.transform = `translate3d(0px, ${y}px, 0px)`;
      }
    }
  }, 200);
  init();
})();
