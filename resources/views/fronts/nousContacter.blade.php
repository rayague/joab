@extends('frontLayout')
    
<main>

  <div class="container col-12 col-12 px-4 py-5">
    <div class="row align-items-center g-lg-5 py-5">
      <div class="col-lg-12 text-center text-lg-center">
        <h1 class="display-4 fw-bold lh-1 mb-3 text-light">Nous Contacter</h1>
        <p class="col-lg-12 text-light">Below is an example form built entirely with Bootstrap’s form controls. Each required form group has a validation state that can be triggered by attempting to submit the form without completing it.</p>
      </div>
    </div>
</div>

<div class="col-md-10 mx-auto col-lg-5 shadow">
  <form class="p-4 p-md-5 border rounded-3 bg-light">
    <div class="form-floating mb-3">
      <input type="email" name="name" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Votre nom</label>
    </div>
    <div class="form-floating mb-3">
        <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
        <label for="floatingInput">Votre email</label>
      </div>
    <div class="form-floating mb-3">
        <textarea name="message" id="message" class="form-control" style="height: 160px"></textarea>
      <label for="floatingPassword">Votre message</label>
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Envoyer</button>
    <hr class="my-4">
    <small class="text-muted">C'est avec plaisir que nous recevrons vos messages.</small>
  </form>
</div>

</main>

