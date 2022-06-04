<template>
  <div>
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
</template>
<script>
import { is422 } from "../../utils/response";
import { logOut } from '../../utils/auth'
import validationErrors from "../../mixins/validationErrors";
export default {
  mixins: [validationErrors],
  // props: ["user"],

  data: function () {
    return {
      user: null,
      updatePasswordform: {
        current_password: null,
        new_password: null,
        confirm_password: null,
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
        .put("/index.php/api/user/" + this.user.id, this.updatePasswordform)
        .then((response) => {
          if (response.status && response.status == 200) {
            axios
        .post("/index.php/logout")
        .then((response) => {
          logOut();
            localStorage.removeItem("current_user");
            this.$router.push({ name: "home" });
        }).catch((error)=>{

        });
          }
        })
        .catch((error) => {
          if (is422(error)) {
            this.errors = error.response.data.errors;
          }
          this.status = error.response.status;
        });
    },
  },
  created(){
    if(localStorage.getItem('current_user')){
        this.user  = (JSON.parse(localStorage.getItem('current_user'))).user;
    }
  }
};
</script>