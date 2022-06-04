<template>
  <div>
    <!-- section-banner -->
    <div v-if="loader">
      <div class="spinner"></div>
    </div>
    <section class="banner-1">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <!-- form html -->
            <div class="box-form box-form-admin center-block">
              <div class="login">
                <h3>
                  Admin
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
  </div>
</template>
<script>
import validationErrors from "./../../mixins/validationErrors";
import { is422 } from "../../utils/response";
import { loginAdmin } from "../../utils/auth";
export default {
  mixins: [validationErrors],
  data() {
    return {
      loader: true,
      status: null,
      errors: null,
      formObj: {
        email: null,
        password: null,
      },
    };
  },
  methods: {
    async getUser() {
      loginAdmin();
      let userData = (await axios.get("/index.php/user")).data;
      const userObj = (await axios.get("/index.php/api/user/" + userData.id)).data;
      localStorage.removeItem("current_user");
      localStorage.setItem("admin_user", JSON.stringify(userObj));
    },
    async Submit() {
      this.loader = true;
      await axios.get("/index.php/sanctum/csrf-cookie");
      axios
        .post("/index.php/login", this.formObj)
        .then((response) => {
          if (response && (response.status == 200 || response.status == 204)) {
            this.getUser();
            this.$router.push({
              name: "admin-listed-services",
            });

            this.loader = false;
          }
        })
        .catch((error) => {
          console.log(error);
          this.loader = false;
          if (is422(error)) {
            console.log("error");
            this.errors = error.response.data.errors;
          }

          this.status = error.response.status;
        })
        .then(() => {
          this.loader = false;
        });
    },
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
};
</script>
<style  scoped>
.box-form {
  margin: 0 auto 0 auto;
}
</style>