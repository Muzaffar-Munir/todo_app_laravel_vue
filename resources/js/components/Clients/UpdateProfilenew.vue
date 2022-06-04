<template>
  <div>
    <div v-if="loader">
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

    <section class="create-account">
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3 tab-responsive">
            <dashboard-nav-component></dashboard-nav-component>
          </div>

          <div class="col-12 col-sm-12 col-md-8 col-lg-9 col-xl-9">
            <div id="update" class="tabcontent" style="display:block">
              <div class="create-account-content"></div>
              <h5>Please fill out the form to update your info.</h5>
              <update-profile-component v-if="userObj" :userData="userObj"></update-profile-component>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import validationErrors from "../../mixins/validationErrors";
import updateProfileComponent from "./updateProfileForm";
import dashboardNavComponent from "./dashboardNav";
import { is422 } from "../../utils/response";
export default {
  components: {
    dashboardNavComponent,
    updateProfileComponent,
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
      loader: true,
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
        .put(
          "/index.php/api/user/" + this.$route.params.user.id,
          this.updatePasswordform
        )
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

    // Get the element with id="defaultOpen" and click on it
  },
  async created() {
    if (this.$route.params.user) {
      this.user = this.$route.params.user;
    } else {
      if (localStorage.getItem("current_user")) {
        this.user = JSON.parse(localStorage.getItem("current_user")).user;
        this.userObj = JSON.parse(localStorage.getItem("current_user"));
      }
    }

    setTimeout(() => {
      this.loader = false;
    }, 1000);
  },
};
</script>