<template>
  <div>
    <!-- modal -->
    <div v-if="loader">
      <div class="spinner"></div>
    </div>
    <div
      class="modal fade model-style"
      id="forgetPasswordModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="pop-up-setting" style="display: flex; align-items: center;">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <form @submit.stop.prevent="resetPassword()">
              <div class="modal-header">
                <h4>Forget Password</h4>
              </div>
              <div class="modal-body">
                <!-- <p>You have Successfully subscribed this Client</p> -->

                <div class="row">
                  <div class="col-md-12">
                    <div class="alert alert-success alert-dismissible" v-if="isSuccess">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>Success!</strong> Please check your email.
                    </div>
                    <input
                      type="email"
                      name="email"
                      v-model="resetEmail"
                      required
                      placeholder="enter your email"
                      class="form-control"
                      :class="[{'is-invalid': errorFor('email')}]"
                    />
                    <div v-if="custom_error" class="invalid-feedback">We can't find a user with that email address.</div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <div class="view-btn view-delete">
                  <button type="submit" class="edit">Submit</button>
                  <button class="delete" data-dismiss="modal">CLOSE</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- ending modal -->
  </div>
</template>
<script>
import validationErrors from "../../mixins/validationErrors";
import { is422 } from "../../utils/response";
export default {
  mixins: [validationErrors],
  data() {
    return {
      resetEmail: null,
      loader: true,
      status: null,
      errors: null,
      isSuccess: false,
      custom_error: null,
    };
  },
  computed: {
    hasErrors() {
      return 422 === this.status && this.errors !== null;
    },
  },
  created(){
    this.loader = false;
  },
  methods: {
    async resetPassword() {
      this.loader = true;
      const post = { email: this.resetEmail };
      const response = await axios
        .post("/index.php/api/user/password-reset-email", post)
        .then((response) => {
          if (response.status && response.status == 200) {
            this.isSuccess = true;
            this.loader = false;
            setTimeout(() => {
              this.isSuccess = false;
              $("body").removeClass("modal-open");
              $(".show").removeClass("modal-backdrop");
              $("body").css("padding-right", "0px");
              $('#forgetPasswordModal').modal('hide');
              this.resetEmail = null;
            }, 2000);
          }
        })
        .catch((error) => {
          console.log(error);
           console.log(error.response.data.message.errors);
          if (is422(error)) {
            this.loader = false;
            this.custom_error = 'email address not found';
            setTimeout(() => {
              this.custom_error = '';
            },5000)
          }
          this.status = error.response.status;
          //  $('#forgetPasswordModal').modal('hide');
          //  this.resetEmail = null;
        });
    },
  },
};
</script>
<style scoped>
.invalid-feedback{
  display:block !important
}
</style>