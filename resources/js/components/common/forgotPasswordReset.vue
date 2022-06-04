<template>
  <div>
    <!-- section-top-->
    <section class="product-services-banner professional-banner">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h3>Password Reset</h3>
          </div>
        </div>
      </div>
    </section>

    <section class="approach-us">
      <div class="container">
        <div class="row mb-4 main-content">
          <!-- <h3>Contact us</h3> -->
          <!-- <p>Please write down your inquery or questions and we will get back to you soon.</p> -->
        </div>
        <div class="row d-flex justify-content-center">
          <div class="col-md-10 col-lg-9 col-xl-8">
            <div class="alert alert-success alert-dismissible" v-if="isSuccess">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Success!</strong> Your Password Updated Successfully.
            </div>
            <div class="alert alert-danger alert-dismissible" v-if="status && status==406">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>You have already used your token. Create a new token to reset your password.</strong>
            </div>
            <div class="approach-form">
              <form @submit.stop.prevent="passwordSubmit()">
                <div class="form-group mb-2 custom-form">
                  <input
                    type="email"
                    name="text"
                    class="form-control"
                    placeholder="Your Email"
                    v-model="updatePasswordform.email"
                    autofocus
                    required
                    readonly
                  />
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
                    <transition-group name="fade" v-if="errors">
                      <p v-for="(error, keyIndex) in errors" :key="keyIndex+'from'">
                        <span v-if="error.password" style="color:#b22222">{{ error.password }}</span>
                      </p>
                    </transition-group>
                  </div>
                </div>
                <div class="create-account-content">
                  <button class="mt-4" type="submit">Update</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import { is422 } from "../../utils/response";
import { logOut } from "../../utils/auth";
import validationErrors from "../../mixins/validationErrors";
export default {
  mixins: [validationErrors],
  // props: ["user"],

  data: function () {
    return {
      user: null,
      isSuccess: null,
      formObj: {
        subject: null,
        message: null,
        email: null,
        contact: null,
      },
      updatePasswordform: {
        email: null,
        new_password: null,
        confirm_password: null,
        token: null,
      },
      errors: null,
      status: null,
    };
  },
  computed: {
    hasErrors() {
      return 422 === this.status && this.errors !== null;
    },
  },
  methods: {
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
    passwordSubmit() {
      axios
        .post("/index.php/api/user-reset-password", this.updatePasswordform)
        .then((response) => {
          if (response.status && response.status == 200) {
            this.isSuccess = "truee";
            setTimeout(() => {
              this.isSuccess = null;
              this.$router.push({ name: "home" });
            }, 3000);
          }
        })
        .catch((error) => {
          if (is422(error)) {
            this.errors = error.response.data.errors;
          }
          this.status = error.response.status;
          if (this.status && this.status == 406) {
            setTimeout(() => {
              this.$router.push({ name: "home" });
            }, 3000);
          }
        });
    },
  },
  created() {
    var url_string = window.location.href;
    var url = new URL(url_string);
    if (url.searchParams.get("email")) {
      this.updatePasswordform.email = url.searchParams.get("email");
    }

    if (this.$route.params.id) {
      this.updatePasswordform.token = this.$route.params.id;
    }
  },
};
</script>