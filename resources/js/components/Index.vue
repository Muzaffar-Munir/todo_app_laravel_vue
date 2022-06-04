<template>
  <div>
    <!-- section-banner -->
    <div v-if="loader">
      <div class="spinner"></div>
    </div>
    <section class="banner-1">
      <div class="container">
        <div class="row row-banner-centered">
          <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <img src="./../../../public/assets/images/logo-banner.1.png" alt="logo" />
            <h2>Do you want to know the secret to increasing your business sales without investing more of your valuable time and hard-earned money?</h2>
            <p class="p-content">
              Imagine having hundreds of sales professionals successfully selling your product or service anywhere in the world without paying them a salary or wage.
              Take a moment to in vision how much more profitable your business would be if you only paid your employee once they had closed a sale rather than a salary or hourly rate to find a sale.
            </p>

            <p
              class="p-content"
            >
        You might be thinking; Yes I can understand how that would help my business be more profitable but how can someone like me find strong skilled sales professionals to sell my product without me paying them a salary? Good Question, click here to find out. <router-link :to="{name:'about-us'}"><span  class="font-weight-bold" style=" color:#5cc9be; ">Learn more...</span></router-link></p>
            
          </div>
          <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <!-- form html -->
            <div class="box-form">
              <div class="login">
                <h3>
                  Already a
                  <span class="cyan-words">Member?</span>
                  Login
                </h3>
              </div>

              <form @submit.stop.prevent="Submit()">
                <div class="form-spacing">
                  <div class="form-group mb-2 custom-form">
                    <input
                      type="email"
                      name="email"
                      class="form-control"
                      placeholder="Email"
                      required
                      autofocus
                      v-model="formObj.email"
                      :class="[{'is-invalid': errorFor('email')}]"
                    />
                    <v-errors :errors="errorFor('email')"></v-errors>
                    <span v-if="errors && errors.message" style="color:#b22222">{{ errors.message }}</span>
                  </div>
                  <div class="form-group custom-form mt-4">
                    <input
                      type="password"
                      name="password"
                      id="password"
                      class="form-control"
                      placeholder="Password"
                      required
                      v-model="formObj.password"
                      :class="[{'is-invalid': errorFor('password')}]"
                    />
                    <v-errors :errors="errorFor('password')"></v-errors>
                  </div>
                  <p class="signup-responsive">
                    Don't have an account?
                    <router-link :to="{name:'freelancerSignUp'}">
                      <span class="cyan-words">Signup</span>
                    </router-link>
                    <a
                      style="cursor:pointer"
                      data-toggle="modal"
                      data-target="#forgetPasswordModal"
                    >
                      <span class="cyan-words forget">forget password ?</span>
                    </a>
                  </p>
                </div>
                <div class="form-group">
                  <button class="btn-block btn-signin mt-4" type="submit">LOGIN</button>
                </div>
              </form>
            </div>
          </div>

          <!-- form html -->
        </div>
      </div>
      <!-- </div> -->
    </section>

    <!-- section-boxes -->
    <section class="section-boxes">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-lg-6">
            <div class="box">
              <ul>
                <li>
                  <img src="./../../../public/assets/images/rocket.png" alt="icons" />Increase Sales
                </li>
                <li>
                  <img src="./../../../public/assets/images/saving.png" alt="icons" />Save Money
                </li>
                <li>
                  <img src="./../../../public/assets/images/globe.png" alt="icons" />Reach More
                </li>
              </ul>
              <router-link :to="{name:'clientSignup'}">
                <button class="btn-block">REGISTER AS A BUSINESS</button>
              </router-link>
            </div>
          </div>
          <div class="col-md-12 col-lg-6">
            <div class="box">
              <ul>
                <li>
                  <img src="./../../../public/assets/images/doller.png" alt="icons" />Increase Income
                </li>
                <li>
                  <img src="./../../../public/assets/images/watch.png" alt="icons" />Flexible Hours
                </li>
                <li>
                  <img src="./../../../public/assets/images/house.png" alt="icons" />Work from Home
                </li>
              </ul>
              <router-link :to="{name:'freelancerSignUp'}">
                <button class="btn-block">REGISTER AS A SALES PROFESSIONAL</button>
              </router-link>
            </div>
          </div>
        </div>
        <!-- forget password modal -->
        <forget-password-component></forget-password-component>
        <!-- ending modal -->
        <!-- contact support modal component -->
        <contact-support-component></contact-support-component>
        <!-- ending -->
      </div>
    </section>
  </div>
</template>
<script>
import validationErrors from "../mixins/validationErrors";
import forgetPasswordComponent from "./common/forgetPassword";
import contactSupportComponent from "./common/contactSupportModal";
import { is422 } from "../utils/response";
import { logIn } from "./../utils/auth";
export default {
  components: {
    forgetPasswordComponent,
    contactSupportComponent,
  },
  mixins: [validationErrors],
  data: () => {
    return {
      resetEmail: null,
      userObj: null,
      loader: true,
      errors: null,
      status: null,
      formObj: {
        email: null,
        password: null,
      },
    };
  },
  computed: {
    hasErrors() {
      return 422 === this.status && this.errors !== null;
    },
  },
  created() {
    setTimeout(() => {
      this.loader = false;
    }, 1000);
  },
  methods: {
    // login action

    async Submit() {
      this.loader = true;
      await axios.get("/index.php/sanctum/csrf-cookie");
      await axios
        .post("/index.php/login", this.formObj)
        .then((response) => {
          this.loader = false;
        })
        .catch((error) => {
          if (is422(error)) {
            this.loader = false;
            this.errors = error.response.data.errors;
          }
          this.status = error.response.status;
        })
        .then(() => {
          this.loader = false;
        });
      let userData = (await axios.get("/index.php/user")).data;
      if (userData.status && userData.status == "inactive") {
        axios.post("/index.php/logout");
        $("#contactSupportModal").modal("show");
        this.formObj = {
          email: null,
          password: null,
        };
        return;
      }
      try {
        this.userObj = (
          await axios.get(
            "/index.php/api/user/" + userData.id + "?profile-details=true",
            { withCredentials: true }
          )
        ).data;
        if (this.userObj) {
          logIn();
          localStorage.setItem("current_user", JSON.stringify(this.userObj));
        }
        if (this.userObj && this.userObj.user.role == "client") {
          this.$router.push({
            name: "create-service",
            params: { user: userData },
          });
          if (
            this.userObj &&
            this.userObj.client &&
            this.userObj.client.subscription_type == 0
          ) {
            localStorage.setItem("show_subscription_update_modal", true);
          }
        } else if (this.userObj && this.userObj.user.role == "freelancer") {
          this.$router.push({
            name: "freelance-profile",
            params: { user: userData },
          });
        } else {
          axios.post("/index.php/logout");
          this.formObj = {
            email: null,
            password: null,
          };
        }
      } catch (error) {
        this.errors = { message: error.response.data.message };
        this.status = error.response.status;
        console.log(this.errors);
        //Error logic here
      }
      // const userObj = (
      //   await axios.get(
      //     "/index.php/api/user/" + userData.id + "?profile-details=true",
      //     { withCredentials: true }
      //   )
      // ).data;
    },
  },
};
</script>
<style>
.spinner {
  /* border: 1px solid; */
  position: fixed;
  z-index: 10000;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  width: 100%;
  height: 100%;
  margin: auto;
  background: #dcdcdc
    url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='2' viewBox='0 0 50 50'%3E%3Cpath d='M28.43 6.378C18.27 4.586 8.58 11.37 6.788 21.533c-1.791 10.161 4.994 19.851 15.155 21.643l.707-4.006C14.7 37.768 9.392 30.189 10.794 22.24c1.401-7.95 8.981-13.258 16.93-11.856l.707-4.006z'%3E%3CanimateTransform attributeType='xml' attributeName='transform' type='rotate' from='0 25 25' to='360 25 25' dur='0.6s' repeatCount='indefinite'/%3E%3C/path%3E%3C/svg%3E")
    center / contain no-repeat;
  opacity: 0.8;
}
.search-info {
  color: rgb(178, 34, 34);
}
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
.list-item {
  display: inline-block;
  margin-right: 10px;
}
.list-enter-active,
.list-leave-active {
  transition: all 1s;
}
.list-enter, .list-leave-to /* .list-leave-active below version 2.1.8 */ {
  opacity: 0;
  transform: translateY(30px);
}
a:hover {
  text-decoration: none !important;
}
.card-title {
  color: white;
}
.preview-image-width {
  width: 15%;
}
.btn-home {
  background-color: #5cc9be;
  color: white;
}
.btn-home:hover {
  color: white;
  text-decoration: none;
}
.btn-close {
  background-color: #333333;
  color: white;
}
.btn-close:hover {
  color: white;
  text-decoration: none;
}
.page-link {
  color: #333232 !important;
}
.page-item.active {
  background-color: #333232 !important;
}
.page-link:hover {
  /* color: white !important; */
}
.page-item.active .page-link {
  /* z-index: 3;
    color: ; */
  background-color: #5cc9be;
  border-color: azure;
}
.page-item.active .page-link:hover {
  color: white !important;
}
.page-item:first-child .page-link {
  margin-left: 0;
  border-top-left-radius: 0;
  border-bottom-left-radius: 0;
}
.page-link:focus {
  box-shadow: unset;
}
.pagination {
  font-size: 26px;
}
.page-item:last-child .page-link {
  border-top-right-radius: 0;
  border-bottom-right-radius: 0;
}
.width-90{
  width: 90% !important;
}
table.vgt-table{
  font-size: 23px !important;
}
</style>