<template>
  <div>
    <div v-if="!user">
      <div class="spinner"></div>
    </div>
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

    <section class="create-account" v-if="user">
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3 tab-responsive">
            <div class="tab">
              <button
                class="tablinks active"
                @click="openTab($event, 'profile')"
                id="defaultOpen"
              >Dashboard</button>
              <button class="tablinks" @click="openTab($event, 'update')">Update Profile</button>
              <button class="tablinks" @click="openTab($event, 'subscribed')">Subscribed Companies</button>
              <button class="tablinks" @click="openTab($event, 'jobs')">Applied Jobs</button>
              <button class="tablinks" @click="openTab($event, 'reset')">Password Reset</button>
              <button
                class="tablinks"
                @click="openTab($event, 'logout')"
                data-toggle="modal"
                data-target="#logOutModal"
              >Logout</button>
            </div>
          </div>

          <div class="col-12 col-sm-12 col-md-8 col-lg-9 col-xl-9">
            <div id="profile" class="tabcontent" style="display:block">
              <view-profile-component :id="user.id" :userObj="userObj"></view-profile-component>
            </div>
            <div id="update" class="tabcontent" style="display:none">
              <h5>Update your profile info.</h5>
              <update-profile-component v-if="userObj" :userData="userObj"></update-profile-component>
            </div>

            <div id="subscribed" class="tabcontent" style="display:none">
              <h5>Manage your Subscribed Companies</h5>
              <subscribed-companies-component></subscribed-companies-component>
            </div>
            <div id="jobs" class="tabcontent" style="display:none">
              <h5>Manage your Applied jobs</h5>
              <applied-jobs-component></applied-jobs-component>
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
import validationErrors from "../../mixins/validationErrors";
import { is422 } from "../../utils/response";
import subscribedCompaniesComponent from "./subscribedCompanies";
import viewProfileComponent from "./viewProfile";
import updateProfileComponent from "./updateProfile";
import appliedJobsComponent from "./appliedJobs";
export default {
  mixins: [validationErrors],
  components: {
    subscribedCompaniesComponent,
    viewProfileComponent,
    updateProfileComponent,
    appliedJobsComponent,
  },
  data: function () {
    return {
      updatePasswordform: {
        current_password: null,
        new_password: null,
        confirm_password: null,
      },
      user: null,
      errors: null,
      userObj: null,
    };
  },
  methods: {
    passwordSubmit() {
      console.log(this.updatePasswordform);
      axios
        .put("api/user/" + this.user.id, this.updatePasswordform)
        .then((response) => {
          console.log(response);
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
          console.log(response);
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
      evt.currentTarget.className += " active";
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
      await axios.get("/index.php/api/user/" + this.user.id + "?profile-details=true")
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
<style scoped>
.slide-fade-enter-active {
  transition: all 0.3s ease;
}
.slide-fade-leave-active {
  transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}
.slide-fade-enter,
.slide-fade-leave-to {
  transform: translateX(10px);
  opacity: 0;
}
.registeration-form {
  padding: 0px;
  margin-top: 0px;
}
</style>