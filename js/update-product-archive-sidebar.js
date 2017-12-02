(function() {
  //////////////////////////////////////////
  // Set the sidebar li classes according //
  // to url query parameters              //
  //////////////////////////////////////////

  // returns query params as array
  function getParameterByName(name, url) {
      if (!url) url = window.location.href
      name = name.replace(/[\[\]]/g, "\\$&")
      var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
          results = regex.exec(url)
      if (!results) return null
      if (!results[2]) return ''
      return decodeURIComponent(results[2].replace(/\+/g, " ")).split(" ")
  }

  var params = getParameterByName('prods')

  // if no params, don't worry about the rest.
  if (!params) return

  function setTitle(title) {
    var titleText = title.textContent
    for (var i = 0; i < params.length; i++) {
      var paramFirstWord = params[i].toLowerCase().split('-')[0]
      var titleTextFirstWord = titleText.toLowerCase().split(' ')[0]
      if (paramFirstWord !== titleTextFirstWord) {
        console.log(title)
        title.textContent = titleText + ' // ' + paramFirstWord
      }
    }
  }

  function setSidebarLiClass(li, params) {
    var linkText = li.children[0].textContent
    for (var i = 0; i < params.length; i++) {
      var paramFirstWord = params[i].toLowerCase().split('-')[0]
      var linkTextFirstWord = linkText.toLowerCase().split(' ')[0]
      if (paramFirstWord === linkTextFirstWord) {
        li.classList.add('current-cat')
      }
    }
  }

  var title = document.getElementsByClassName('woocommerce-products-header__title page-title')[0]
  setTitle(title)

  // set
  var sidebarListItems = document.querySelectorAll('.product-categories li')
  sidebarListItems.forEach(function(li) {
    // reset classes
    li.classList.remove('current-cat')
    setSidebarLiClass(li, params)
  })
})()
