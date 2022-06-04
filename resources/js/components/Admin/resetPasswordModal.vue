<template>
  <div>
    <div v-if="loader">
      <div class="spinner"></div>
    </div>
    <!-- modal -->
    <div
      class="modal fade model-style"
      id="resetPasswordModal"
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
                <h4>Update Password</h4>
              </div>
              <div class="modal-body">
                <!-- <p>You have Successfully subscribed this Client</p> -->

                <div class="row">
                  <div class="col-md-12 form-group mb-2 custom-form">
                    <input
                      type="password"
                      name="password"
                      class="form-control"
                      placeholder="Password"
                      required
                      autofocus
                      v-model="updatePasswordform.new_password"
                      :class="[{'is-invalid': errorFor('new_password')}]"
                    />
                    <v-errors :errors="errorFor('new_password')"></v-errors>
                  </div>

                  <div class="col-md-12 form-group mb-2 custom-form">
                    <input
                      type="password"
                      name="password"
                      class="form-control"
                      placeholder="Confirm Password"
                      required
                      v-model="updatePasswordform.confirm_password"
                      :class="[{'is-invalid': errorFor('confirm_password')}]"
                    />
                    <v-errors :errors="errorFor('confirm_password')"></v-errors>
                  </div>
                </div>
                <!-- <div class="create-account-content">
                  <button class="mt-4"  @click="passwordSubmit()">Update</button>
                </div>-->
              </div>
              <div class="modal-footer">
                <div class="view-btn view-delete">
                  <button type="submit" class="edit" @click.stop.prevent="passwordSubmit()">Update</button>
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
import { is422 } from "../../utils/response";
import validationErrors from "../../mixins/validationErrors";
export default {
  mixins: [validationErrors],
  props: ["id"],
  data() {
    return {
      errors: null,
      status: null,
      loader: true,
      updatePasswordform: {
        new_password: null,
        confirm_password: null,
      },
    };
  },
  watch: {
    id: function (val) {
      this.updatePasswordform = {
        new_password: null,
        confirm_password: null,
      };
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
      this.loader = true;
      axios
        .put("/index.php/api/users/update-password/" + this.id, this.updatePasswordform)
        .then((response) => {
          if (response.status && response.status == 200) {
            this.updatePasswordform = {
              new_password: null,
              confirm_password: null,
            };
            this.loader = false;
            $("#resetPasswordModal").modal("hide");
            $("body").removeClass("modal-open");
            $(".fade").removeClass("modal-backdrop");
            $("body").css("padding-right", "0px");
          }
        })
        .catch((error) => {
          this.loader = false;
          if (is422(error)) {
            this.errors = error.response.data.errors;
          }
          this.status = error.response.status;
        })
        .then(() => {
          this.loader = false;
        });
    },
  },
  created() {
    setTimeout(() => {
      this.loader = false;
    }, 1000);
  },
};
</script>