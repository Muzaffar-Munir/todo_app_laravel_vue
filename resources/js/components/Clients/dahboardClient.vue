<template>
  <div>
    <!-- section-top-->
    <section class="create-account-banner">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
             <h3>Dashboard</h3>
          </div>
        </div>
      </div>
    </section>

    <section class="create-account">
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3 tab-responsive">
            <div class="tab">
              <button
                class="tablinks active profile"
                @click="openTab('profileTab', 'profile')"
                id="profileTab"
              >Create an Ad</button>
              <button
                class="tablinks"
                id="updateTab"
                @click="openTab('updateTab', 'update')"
              >Update Profile</button>
              <button
                class="tablinks reset"
                id="resetTab"
                @click="openTab('resetTab', 'reset')"
              >Password Reset</button>
              <button
                class="tablinks cancel"
                id="cancelTab"
                @click="openTab('cancelTab', 'cancel')"
              >Cancel Subscription</button>
              <button
              id="logoutTab"
                class="tablinks logout"
                @click="openTab('logoutTab', 'logout')"
                data-toggle="modal"
                data-target="#logOutModal"
              >Logout</button>
            </div>
          </div>

          <div class="col-12 col-sm-12 col-md-8 col-lg-9 col-xl-9">
            <div id="profile" class="tabcontent" style="display:block">
              <h5>Please fill out the form to complete the registration.</h5>
              <div class="create-account-content">
                <router-link :to="{name:'clientListServices'}">
                  <button>Manage</button>
                </router-link>
              </div>
              <create-client-service-component :type="'create'" :user="user"></create-client-service-component>
            </div>

            <div id="update" class="tabcontent" style="display:none">
              <h5>Update your profile info.</h5>
              <update-profile-component v-if="userObj" :userData="userObj"></update-profile-component>
            </div>

            <div id="reset" class="tabcontent" style="display:none">
              <h5>Please fill out the form to update your password.</h5>
              <div class="create-account-form">
                <form @submit.stop.prevent="passwordSubmit()">
                  <div class="form-group mb-2 custom-form">
                    <input
                      type="password"
                      name="text"
                      class="form-control"
                      placeholder="Enter Your Current Password"
                      v-model="updatePasswordform.current_password"
                      autofocus
                      required
                      :class="[{'is-invalid': errorFor('current_password')}]"
                    />
                    <v-errors :errors="errorFor('current_password')"></v-errors>
                  </div>
                  <div class="half-form">
                    <div class="form-group mb-2 custom-form registeration-form-1">
                      <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Password"
                        required
                        v-model="updatePasswordform.new_password"
                        @input="matchPassword()"
                        :class="[{'is-invalid': errorFor('new_password')}]"
                      />
                      <v-errors :errors="errorFor('new_password')"></v-errors>
                      <transition name="slide-fade" v-if="errors">
                        <p v-for="(error, keyIndex) in errors" :key="keyIndex+'from'">
                          <span v-if="error.password" style="color:#b22222">{{ error.password }}</span>
                        </p>
                      </transition>
                    </div>

                    <div class="form-group mb-2 custom-form registeration-form-2">
                      <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Confirm Password"
                        required
                        @input="matchPassword()"
                        v-model="updatePasswordform.confirm_password"
                        :class="[{'is-invalid': errorFor('confirm_password')}]"
                      />
                      <v-errors :errors="errorFor('confirm_password')"></v-errors>
                      <transition name="fade" v-if="errors">
                        <p v-for="(error, keyIndex) in errors" :key="keyIndex+'from'">
                          <span v-if="error.password" style="color:#b22222">{{ error.password }}</span>
                        </p>
                      </transition>
                    </div>
                  </div>
                  <div class="create-account-content">
                    <button class="mt-4">Update</button>
                  </div>
                </form>
              </div>
            </div>

            <div id="cancel" class="tabcontent" style="display:none">
              <h5>Are you sure you want to cancel?</h5>
              <div class="create-account-form">
                <form>
                  <div class="form-group mb-2 custom-form">
                    <textarea
                      class="form-control foam-border comment-box"
                      placeholder="Please Leave Feeback to Help us Improve!"
                      rows="6"
                      required
                      cols="50"
                      name="comment"
                      form="usrform"
                    ></textarea>
                  </div>
                </form>
                <div class="create-account-content">
                  <button class="mt-4" data-toggle="modal" data-target="#exampleModal">CANCEL</button>
                </div>
                <!-- Modal -->
                <div
                  class="modal fade model-style"
                  id="exampleModal"
                  tabindex="-1"
                  role="dialog"
                  aria-labelledby="exampleModalLabel"
                  aria-hidden="true"
                >
                  <div class="pop-up-setting" style="display: flex; align-items: center;">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                          >
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p>
                            Thank you! for using our service, your feedback is most appreciated.
                            We hope to see you again!
                          </p>
                          <img src="./../../../../public/assets/images/smily-face.png" alt="smile" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div id="logout" class="tabcontent" style="display:none">
              <div class="create-account-form">
                <p>Are you sure You want to Logout?</p>
                <div>
                  <button type="button" class="btn btn-danger" id="yes-btn" @click="logout()">Yes</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import createClientServiceComponent from "../Services/createClientService";
import validationErrors from "../../mixins/validationErrors";
import updateProfileComponent from "./updateProfileForm";
import myListedAdsComponent from "./listServices";
import { is422 } from "../../utils/response";
export default {
  components: {
    createClientServiceComponent,
    updateProfileComponent,
    myListedAdsComponent,
  },
  mixins: [validationErrors],
  computed: {
    hasErrors() {
      return 422 === this.status && this.errors !== null;
    },
  },
  data: function () {
    return {
      userObj: null,
      updatePasswordform: {
        current_password: null,
        new_password: null,
        confirm_password: null,
      },
      serviceForm: {
        description: null,
        price: null,
        sales_method: null,
        audience: null,
        location: null,
        url: null,
        client_id: null,
        requirements: null,
      },
      status: null,
      errors: null,
      user: null,
    };
  },
  async beforeCreate() {
    if (this.$route.params.user) {
      this.user = this.$route.params.user;
    } else {
      this.user = (await axios.get("/index.php/user")).data;
    }
  },
  methods: {
    passwordSubmit() {
      axios
        .put("/index.php/api/user/" + this.$route.params.user.id, this.updatePasswordform)
        .then((response) => {
          if (response.status && response.status == 200) {
            this.$router.push({ name: "home" });
          }
        })
        .catch((error) => {
          if (is422(error)) {
            this.errors = error.response.data.errors;
          }
          this.status = error.response.status;
        });
    },
    logout() {
      axios
        .post("/index.php/logout")
        .then((response) => {
          if (response.status && response.status == 204) {
            localStorage.removeItem("current_user");
            this.$router.push({ name: "home" });
          }
        })
        .catch((err) => {});
    },
    matchPassword() {
      if (
        this.updatePasswordform.new_password &&
        this.updatePasswordform.confirm_password &&
        this.updatePasswordform.new_password !=
          this.updatePasswordform.confirm_password
      ) {
        this.errors = [{ password: "password not matched" }];
        return;
      } else {
        return (this.errors = null);
      }
    },
    openTab(evt, cityName) {
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablinks");
      for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
      }
      document.getElementById(cityName).style.display = "block";
      // evt.currentTarget.className += " active";
      // document.getElementById(cityName).classList.add("active");
      document.getElementById(evt).classList.add("active");
    },

    // Get the element with id="defaultOpen" and click on it
  },
  async created() {
    if (this.$route.params.user) {
      this.user = this.$route.params.user;
    } else {
      this.user = (
        await axios.get("/index.php/user").catch((error) => {
          const resonse = JSON.parse(JSON.stringify(error));
          if (resonse.message == "Request failed with status code 401") {
            this.$router.push({ name: "home" });
          }
        })
      ).data;
    }

    this.userObj = (
      await axios.get(
        "/index.php/api/user/" + this.user.id + "?profile-details=true&type=client"
      )
    ).data;
    if (
      !localStorage.getItem("current_user") ||
      localStorage.getItem("current_user") == null
    ) {
      localStorage.setItem("current_user", JSON.stringify(this.userObj));
    }
  },
};
</script>