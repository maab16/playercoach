<template>
	<div class="wrapper">
	 <h1>Profile</h1>
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active">
          <a href="#profile" class="nav-link active" data-toggle="tab" aria-expanded="true">
            <i class="fa fa-user-o"></i> Edit Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#orders" data-toggle="tab" aria-expanded="false">
            <i class="fa fa-shopping-cart"></i> Addresses</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#invoices" data-toggle="tab" aria-expanded="false">
            <i class="fa fa-file-text-o"></i> Auth &amp; Password</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#invoices" data-toggle="tab" aria-expanded="false">
            <i class="fa fa-file-text-o"></i> Notification Preferences</a>
        </li>

      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="profile">
          <form>                    
            <div class="form-group">
              <label for="name" class="col-form-label text-md-right">Name</label>
              <input
                   id="name"
                   type="text"
                   class="form-control"
                   name="name"
                   v-model="user.name"
                   autocomplete="name"
                   autofocus>
            </div>

            <div class="form-group">
               <label for="email" class="col-form-label text-md-right">E-Mail Address</label>
               <input
                   id="email"
                   type="email"
                   class="form-control"
                   name="email"
                   v-model="user.email"
                   autocomplete="email">
            </div>

            <div class="form-group">
               <label for="password" class="col-form-label text-md-right">Password</label>
               <input
                   id="password"
                   type="password"
                   class="form-control"
                   name="password"
                   v-model="user.password"
                   autocomplete="new-password">
            </div>

            <div class="form-group">
               <label
                   for="password-confirm"
                   class="col-form-label text-md-right">Confirm Password</label>
               <input
                   id="password-confirm"
                   type="password"
                   class="form-control"
                   name="password_confirmation"
                   v-model="user.password_confirmation"
                   autocomplete="new-password">
            </div>

            <div class="form-group">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success">Update</button>
            </div>
          </form>
        </div>
        <div class="tab-pane" id="orders">
          Addresses
        </div>
        <div class="tab-pane" id="invoices">
          Auth &amp; Password
        </div>
        <div class="tab-pane" id="invoices">
          Notification
        </div>
      </div>
    </div>
	</div>
</template>

<script>
    // Set Default functionality for all vue components
    export default {
        data() {
            return {
                user: {
                  name: '',
                  email: '',
                  password: '',
                  password_confirmation: '',
                }
            }
        },
        created(){},
        methods: {
            
        },
        mounted() {},
    }
</script>

<style scoped="scoped">
  .tab-content {
    padding: 15px;
    background-color: #fff;
  }
  .nav-tabs li {
    margin-right: 5px;
  }
  .nav-tabs li.active {
    margin-bottom: -2px;
  }
  .nav-tabs li a {
    border-top: 3px solid transparent;
  }
  .nav-tabs li a:hover,
  .nav-tabs li a.active {
    border-top-color: #3c8dbc !important;
    border-left-color: #f4f4f4;
    border-right-color: #f4f4f4;
    background-color: #fff;
    color: #444;
  }
</style>