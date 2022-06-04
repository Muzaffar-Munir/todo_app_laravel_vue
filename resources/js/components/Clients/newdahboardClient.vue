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
            <dashboard-nav-component></dashboard-nav-component>
          </div>

          <div class="col-12 col-sm-12 col-md-8 col-lg-9 col-xl-9">
            <div id="create" class="tabcontent" style="display:block">
              <h5>Please fill out the form to complete the registration.</h5>
              <div class="create-account-content">
                <router-link :to="{name:'clientListServices'}">
                  <button>Manage</button>
                </router-link>
              </div>
              <create-client-service-component :type="'create'" :user="user"></create-client-service-component>
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
import dashboardNavComponent from "./dashboardNav";
import { is422 } from "../../utils/response";
export default {
  components: {
    createClientServiceComponent,
    dashboardNavComponent,
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