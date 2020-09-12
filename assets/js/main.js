$(document).ready(function () {
  $("#btn_log").click(loginRegular);
  $("#btn_submit").click(registrationCheck);

  $(".filter_categories").click(fetchBooks);
  $(".filter_autor").click(fetchBooks);
  $("#search").keyup(search);

  $("#file_btn").click(function (e) {
    e.preventDefault();
    $("#image").click();
  });
  $(".add_cart").click(addToCart);

  var books = JSON.parse(localStorage.getItem("books"));

  if (!books) {
    // praznaKorpa();
  } else {
    showProducts();
  }

  // console.log(window.location.href);

  $("#create_order").click(order);

  $(".edit_category").click(getCategoryName);

  $(".delete_category").click(removeCategory);

  $(".edit_autor").click(getAutorName);

  $(".delete_autor").click(removeAutor);

  $("#add_category_btn").click(categoryRegular);

  $("#btn_add_autor").click(autorRegular);

  $("#delete_order").click(function () {
    removeLocalStorage();
    location.reload();
  });
});

function loginRegular(e) {
  e.preventDefault();

  let username = $("#username").val();
  let password = $("#password").val();

  let usernameReg = /^[a-z]+(\w+[!@#$%^&*]+|[!@#$%^&*]+\w+)[\w!@#$%^&*]/;
  let passwordReq = /[a-z0-9A-Z]+[!@#$%^&*]{1}[a-z0-9A-Z]+/;
  var error = [];

  if (!usernameReg.test(username)) {
    $("#username")
      .next()
      .fadeIn();
    error = "Username nije ok";
  } else {
    $("#username")
      .next()
      .fadeOut();
  }

  if (!passwordReq.test(password)) {
    $("#password")
      .next()
      .fadeIn();
    error = "Passworod nije ok";
  } else {
    $("#password")
      .next()
      .fadeOut();
  }

  if (error.length != 0) {
    console.log(error);
  } else {
    $.ajax({
      type: "post",
      url: "index.php?page=login_user",
      data: {
        username: username,
        password: password,
        send: true
      },
      dataType: "json",
      success: function (data, text, xhr) {
        console.log(xhr);
        // alert(xhr.responseJSON.message);
        window.location.href = "index.php";
      },
      error: function (xhr, text, err) {
        console.log(xhr);
        // alert(xhr.responseJSON.message);
        if (xhr.status == 422) {
          $("#login_error").html("<h3>Podaci nisu ok</h3>");
        }
        if (xhr.status == 500) {
          alert("Greska, pokusajte ponovo");
        }
        if (xhr.status == 409) {
          alert(xhr.responseJSON.message);
        }
      }
    });
  }
}

function registrationCheck() {
  let name = $("#name").val();
  let lastname = $("#lastname").val();
  let username = $("#username").val();
  let password = $("#password").val();
  let email = $("#email").val();
  //regularni
  let nameReg = /[A-Z]{1}[a-z]+/;
  let usernameReg = /^[a-z]+(\w+[!@#$%^&*]+|[!@#$%^&*]+\w+)[\w!@#$%^&*]/;
  let passwordReq = /[a-z0-9A-Z]+[!@#$%^&*]{1}[a-z0-9A-Z]+/;
  let emailReg = /^[\w\.]+@(gmail\.com|yahoo\.com|ict\.edu\.rs)/;

  var errors = [];

  if (!nameReg.test(name)) {
    errors.push("Ime nije ok");
  } else {
    console.log("Ime je ok");
  }
  if (!nameReg.test(lastname)) {
    errors.push("Prezime nije ok");
  } else {
    console.log("Prezime je ok");
  }
  if (!usernameReg.test(username)) {
    errors.push("Username nije ok");
  } else {
    console.log("Username je ok");
  }
  if (!passwordReq.test(password)) {
    errors.push("Password nije ok");
  } else {
    console.log("Password je ok");
  }
  if (!emailReg.test(email)) {
    errors.push("Email nije ok");
  } else {
    console.log("Email je ok");
  }

  // console.log(errors);

  if (errors.length == 0) {
    $.ajax({
      type: "post",
      url: "index.php?page=register_user",
      data: {
        name: name,
        username: username,
        lastname: lastname,
        password: password,
        email: email,
        send: true
      },
      dataType: "json",
      success: function (data, text, xhr) {
        console.log(xhr);

        alert(xhr.responseJSON.message);
        window.location.href = "index.php";
      },
      error: function (xhr, text, err) {
        console.log(xhr);
        if (xhr.status == 422) {
          $(".error").html("Uneti podaci nisu ok");
        }
        if (xhr.status == 500) {
          alert("Greska, pokusajte ponovo");
        }
        if (xhr.status == 409) {
          alert(xhr.responseJSON.message);
        }
      }
    });
  }
  else {
    console.log(errors);
  }
}

//fatch products

function fetchBooks(e) {
  // console.log($(this));
  // console.log($(".filter_autor"));
  if ($(this).hasClass("filter_autor")) {
    e.preventDefault();
  }

  var categories = $(".filter_categories:checked");
  var categoriesValue = arrayValue(categories);
  // console.log(categoriesValue);
  var autor = $(this).data("id");

  console.log(autor);

  $.ajax({
    type: "post",
    url: "index.php?page=fetch",
    data: {
      categories: categoriesValue,
      autor: autor,
      fetch: true
    },
    dataType: "json",
    success: function (data, text, xhr) {
      console.log(xhr);
      showBooks(data);
    },
    error: function (xhr, text, err) {
      console.log(xhr);
    }
  });
}

function search() {
  var search = $("#search").val();
  // console.log(search);

  $.ajax({
    type: "post",
    url: "index.php?page=fetch",
    data: {
      search: search,
      fetch: true
    },
    dataType: "json",
    success: function (data, text, xhr) {
      console.log(xhr);
      console.log(data);

      showBooks(data);
    },
    error: function (xhr, text, err) {
      console.log(xhr);
    }
  });
}

function arrayValue(className) {
  var filter = [];
  className.each(function () {
    filter.push($(this).val());
    // console.log();
  });
  return filter;
}

function showBooks(books) {
  let string = "";

  books.forEach(book => {
    string += `
        <div class="col-lg-4 col-sm-6">
        <div class="single_product_item">
            <img src="assets/img/books/${book.src}" alt="${book.alt}">
            <div class="single_product_text">
                <h4>${book.title}</h4>
                <h3>${book.price}</h3>
                <a href="#" data-id='${book.id_book}' class="add_cart">+ add to cart</a>
            </div>
        </div>
    </div>`;
  });
  $(".latest_product_inner").html(string);
  $(".add_cart").click(addToCart);
}

// korpa

function productsInLocalStorage() {
  return JSON.parse(localStorage.getItem("books"));
}

function addToCart(e) {
  e.preventDefault();

  var idBook = $(this).data("id");
  var books = productsInLocalStorage();
  var idUser;
  // console.log(idBook);

  $.ajax({
    type: "post",
    url: "index.php?page=user_id",
    dataType: "json",
    success: function (data, text, xhr) {
      // console.log(xhr);
      // console.log()
      idUser = xhr.responseJSON.message;
      // console.log(idUser);

      if (books) {
        if (daLiPostojiUNizu()) {
          increaseQuantity();
        } else {
          addNewBook();
        }
      } else {
        firstBook();
      }
    },
    error: function (err) {
      console.log(err);
    }
  });

  function firstBook() {
    var books = [];

    books[0] = {
      idBook: idBook,
      idUser: idUser,
      quantity: 1
    };

    localStorage.setItem("books", JSON.stringify(books));
  }

  function addNewBook() {
    var books = productsInLocalStorage();

    books.push({
      idBook: idBook,
      idUser: idUser,
      quantity: 1
    });

    localStorage.setItem("books", JSON.stringify(books));
  }

  function increaseQuantity() {
    var books = productsInLocalStorage();
    console.log(books);

    for (let book of books) {
      if (book.idBook == idBook) {
        book.quantity++;
        break;
      }
    }

    localStorage.setItem("books", JSON.stringify(books));
  }

  function daLiPostojiUNizu() {
    return books.filter(x => x.idBook == idBook).length; // vraca 1 ili 0
  }
}

// prikaz korpe

function showProducts() {
  var books = JSON.parse(localStorage.getItem("books"));

  console.log(books);

  var filter = []; // idProizvoda u localStorage

  for (let book of books) {
    filter.push(book.idBook);
  }

  console.log(filter);

  // ------------------------ZAHTEV ZA DOHVATANJE SVIH PROIZVODA IZ BAZE-----------------------------

  $.ajax({
    url: "index.php?page=shop_cart",
    method: "post",
    dataType: "json",
    data: {
      idBooks: filter
    },
    success: function (data, text, xhr) {
      console.log(data); // svi proizvodi iz baze
      console.log(xhr);
      data = data.filter(d => {
        for (b of books) {
          if (d.id_book == b.idBook) {
            d.quantity = b.quantity;
            return true;
          }
        }
      });
      // console.log(data);
      displayBooks(data);
    },
    error: function (xhr, text, error) {
      console.log(xhr);
    }
  });

  function displayBooks(books) {
    let string = "";
    books.forEach(b => {
      string += ` 
        <tr>
          <td>
            <div class="media">
              <div class="d-flex">
                <img src="assets/img/books/" alt="" />
              </div>
              <div class="media-body">
                <p>${b.title}</p>
              </div>
            </div>
          </td>
          <td>
            <h5>$${b.price}</h5>
          </td>
          <td>
            <div class="product_count">
              <p>${b.quantity}</p>
            </div>
          </td>
          <td>
            <h5>${b.price * b.quantity}</h5>
          </td>
        </tr>
        <tr>`;
    });
    $("#cart").html(string);
  }
}

function order(e) {
  e.preventDefault();

  var localStorageBooks = JSON.parse(localStorage.getItem("books"));
  var idUser = JSON.parse(localStorage.getItem("books"))[0].idUser;
  // console.log(idUser);
  var filterId;
  var filterQuantity;
  // filterId = localStorageBooks.map(x => x.idBook);
  filterId = localStorageBooks.map(x => x.idBook);
  filterQuantity = localStorageBooks.map(x => x.quantity);

  console.log(filterId);

  $.ajax({
    type: "post",
    url: "index.php?page=order",
    data: {
      idUser: idUser,
      idBooks: filterId,
      quantity: filterQuantity,
      send: true
    },
    dataType: "json",
    success: function (data, text, xhr) {
      console.log(xhr);
      alert(xhr.responseJSON.message);
      removeLocalStorage();
      window.location.href = "index.php";
    },
    error: function (xhr, text, err) {
      console.log(xhr);
      alert(xhr.responseJSON.message);
    }
  });
}

function removeLocalStorage() {
  localStorage.removeItem("books");
}

function getCategoryName(e) {
  e.preventDefault();
  let idCategory = $(this).data("id");

  // console.log(idCategory);
  $.ajax({
    type: "get",
    url: "index.php?page=admin&param=get_one_category",
    data: { id: idCategory },
    dataType: "json",
    success: function (data, text, xhr) {
      console.log(xhr);
      // console.log(data.name);
      loadFormEditCategory(data);
    },
    error: function (xhr, text, err) {
      console.log(xhr);
    }
  });
}

function loadFormEditCategory(data) {
  let string = `
  <div class="card-header">
    <h2>Edit</h2>
  </div>
  <div class="card-body">
    <form action="index.php?page=admin&param=insert_category" method="post">
      <input type="text" name="name" id="name" value='${data.name}'><br>
      <input type="button" id='edit_category_btn' value='izmeni' name='edit_category_btn' data-id='${data.id_category}'>
    <div class='error'></div>

    </form>
  </div>`;

  $("#edit_form_category").html(string);
  $("#edit_category_btn").click(editCategory);
}

function editCategory() {
  let idCategory = $("#edit_category_btn").data("id");
  let value = $("#name").val();

  // console.log(value);
  // console.log(idCategory);

  $.ajax({
    type: "post",
    url: "index.php?page=admin&param=edit_category",
    data: { idCategory: idCategory, name: value },
    dataType: "json",
    success: function (data, text, xhr) {
      // console.log(xhr);
      $(".error").hide();

      getAllCategories();

      // console.log(data.name);
    },
    error: function (xhr, text, err) {
      console.log(xhr);
      if (xhr.status == 500) {
        alert(xhr.responseJSON.message);
      }
      if (xhr.status == 422) {
        $(".error").html("Ime nije ok");
      }
    }
  });
}

function getAllCategories() {
  $.ajax({
    type: "get",
    url: "index.php?page=admin&param=all_categories",
    dataType: "json",
    success: function (data, text, xhr) {
      // console.log(xhr);

      displayCategories(data);
    },
    error: function (xhr, text, err) {
      console.log(xhr);
    }
  });
}

function displayCategories(categories) {
  var string = `<table cellspacing="10">
  <tr>
      <td>Id</td>
      <td>Naziv</td>
      <td>Obrisi</td>
      <td>izmeni</td>
  </tr>`;
  categories.forEach(cat => {
    string += `
          <tr>
              <td>${cat.id_category}</td>
              <td>${cat.name}</td>
              <td><a href="#" class='delete_category' data-id=${cat.id_category}>Obrisi</a></td>
              <td><a href="#" class='edit_category' data-id=${cat.id_category}>Izmeni</a></td>
          </tr>
    `;
  });
  string += `</table>`;
  $("#categories").html(string);
  $(".edit_category").click(getCategoryName);
  $(".delete_category").click(removeCategory);
}

function removeCategory(e) {
  e.preventDefault();
  let idCategory = $(this).data("id");

  // console.log(idCategory);

  $.ajax({
    type: "post",
    url: "index.php?page=admin&param=delete_category",
    data: {
      id: idCategory
    },
    dataType: "json",
    success: function (data, text, xhr) {
      console.log(xhr);
      $(".error").hide();

      getAllCategories();
    },
    error: function (xhr, text, err) {
      console.log(xhr);
      if (xhr.status == 500) {
        alert(xhr.responseJSON.message);
      }
    }
  });
}

function getAutorName(e) {
  e.preventDefault();
  let idAutor = $(this).data("id");

  console.log(idAutor);
  $.ajax({
    type: "post",
    url: "index.php?page=admin&param=get_one_autor",
    data: { id: idAutor },
    dataType: "json",
    success: function (data, text, xhr) {
      // console.log(xhr);
      // console.log(data);
      loadFormEditAutor(data);
    },
    error: function (xhr, text, err) {
      console.log(xhr);
    }
  });
}

function loadFormEditAutor(data) {
  let string = `
  <div class="card-header">
    <h2>Edit</h2>
  </div>
  <div class="card-body"><form action="index.php?page=admin&param=insert_category" method="post">
    <input type="text" name="first_name" id="first_name" value='${data.first_name}'>
    <span class="hidden_err">Ime nije ok</span>
    <input type="text" name="last_name" id="last_name" value='${data.last_name}'>
    <span class="hidden_err">Prezime nije ok</span>
    <input type="button" id='edit_autor_btn' value="Izmeni" name='edit_autor_btn' data-id='${data.id_autor}'>
    <div class='error'></div>
  </form></div>
  `;

  $("#edit_form_autor").html(string);
  $("#edit_autor_btn").click(editAutor);
}

function editAutor() {
  let idAutor = $("#edit_autor_btn").data("id");
  let firstName = $("#first_name").val();
  let lastName = $("#last_name").val();
  let nameReg = /^[A-Z][a-z]+$/;
  let error = [];

  if (!nameReg.test(firstName)) {
    // console.log("nije");
    $("#first_name")
      .next()
      .fadeIn();
    error.push("Ime nije ok");
  } else {
    $("#first_name")
      .next()
      .fadeOut();
  }

  if (!nameReg.test(lastName)) {
    // console.log("nije");
    $("#last_name")
      .next()
      .fadeIn();
    error.push("Prezime nije ok");
  } else {
    $("#last_name")
      .next()
      .fadeOut();
  }

  if (error.length == 0) {
    console.log("poslato");
    $.ajax({
      type: "post",
      url: "index.php?page=admin&param=edit_autor",
      data: { id: idAutor, firstName: firstName, lastName: lastName },
      dataType: "json",
      success: function (data, text, xhr) {
        // console.log(xhr);
        $(".error").hide();

        getAllAutors();
      },
      error: function (xhr, text, err) {
        console.log(xhr);
        if (xhr.status == 422) {
          $(".error").html("Podaci nisu ok");
        }
      }
    });
  }
}

function getAllAutors() {
  $.ajax({
    type: "get",
    url: "index.php?page=admin&param=all_autors",
    dataType: "json",
    success: function (data, text, xhr) {
      // console.log(xhr);

      displayAutors(data);
    },
    error: function (xhr, text, err) {
      console.log(xhr);
    }
  });
}

function displayAutors(autors) {
  var string = `<table cellspacing="10">
  <tr>
      <td>Id</td>
      <td>Ime</td>
      <td>Prezime</td>
      <td>Obrisi</td>
      <td>izmeni</td>
  </tr>`;
  autors.forEach(a => {
    string += `
          <tr>
              <td>${a.id_autor}</td>
              <td>${a.first_name}</td>
              <td>${a.last_name}</td>
              <td><a href="#" class='delete_autor' data-id=${a.id_autor}>Obrisi</a></td>
              <td><a href="#" class='edit_autor' data-id=${a.id_autor}>Izmeni</a></td>
          </tr>
    `;
  });
  string += `</table>`;
  $("#autors").html(string);
  $(".edit_autor").click(getAutorName);
  $(".delete_autor").click(removeAutor);
}

function removeAutor(e) {
  e.preventDefault();
  let idAutor = $(this).data("id");

  // console.log(idCategory);

  $.ajax({
    type: "post",
    url: "index.php?page=admin&param=delete_autor",
    data: {
      id: idAutor
    },
    dataType: "json",
    success: function (data, text, xhr) {
      // console.log(xhr);
      $(".error").hide();

      getAllAutors();
    },
    error: function (xhr, text, err) {
      console.log(xhr);
      if (xhr.status == 500) {
        alert("Greska, pokusajte ponovo");
      }
    }
  });
}

function categoryRegular() {
  let name = $("#name").val();
  let nameReg = /^[A-Z][a-z]+$/;
  let error = [];
  // console.log(name);
  if (!nameReg.test(name)) {
    // console.log("nije");
    $("#name")
      .next()
      .fadeIn();
    error.push("Ime nije ok");
  } else {
    $("#name")
      .next()
      .fadeOut();
  }

  // console.log(error);
  if (error.length == 0) {
    console.log("poslato");
    $.ajax({
      type: "post",
      url: "index.php?page=admin&param=insert_category",
      data: {
        name: name
      },
      dataType: "json",
      success: function (data, text, xhr) {
        console.log(xhr);
        if (xhr.status == 204) {
          window.location.href = "index.php?page=admin&param=categories";
        }
      },
      error: function (xhr, text, err) {
        console.log(xhr);
        if (xhr.status == 422) {
          $("#name")
            .next()
            .fadeIn();
        }
        if (xhr.status == 500) {
          alert("Pokusajte ponovo");
        }
      }
    });
  }
}

function autorRegular() {
  let firstName = $("#first_name").val();
  let lastName = $("#last_name").val();
  let nameReg = /^[A-Z][a-z]+$/;
  let error = [];

  // if (!nameReg.test(firstName)) {
  //   // console.log("nije");
  //   $("#first_name")
  //     .next()
  //     .fadeIn();
  //   error.push("Ime nije ok");
  // } else {
  //   $("#first_name")
  //     .next()
  //     .fadeOut();
  // }

  // if (!nameReg.test(lastName)) {
  //   // console.log("nije");
  //   $("#last_name")
  //     .next()
  //     .fadeIn();
  //   error.push("Prezime nije ok");
  // } else {
  //   $("#last_name")
  //     .next()
  //     .fadeOut();
  // }

  if (error.length == 0) {
    console.log("poslato");
    $.ajax({
      type: "post",
      url: "index.php?page=admin&param=insert_autor",
      data: {
        firstName: firstName,
        lastName: lastName,
        send: true
      },
      dataType: "json",
      success: function (data, text, xhr) {
        console.log(xhr);
        $(".error").hide();
        window.location.href = "index.php?page=admin&param=autors";
      },
      error: function (xhr, text, err) {
        console.log(xhr);
        if (xhr.status == 422) {
          $(".error").html("Podaci nisu ok");
        }
      }
    });
  }
}
