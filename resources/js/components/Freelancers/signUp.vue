<template>
  <div>
    <!-- section-top-->
    <section class="register-form-banner">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <!-- <h3>Subscription Registration Form</h3> -->
          </div>
        </div>
      </div>
    </section>

    <section class="register-sec">
      <div class="container">
        <div class="row mb-4 main-content">
          <h3>FREELANCER PROFILE REGISTRATION</h3>
          <p>Please fill out the form to complete the registration.</p>
        </div>
        <div v-if="loader">
          <div class="spinner"></div>
        </div>
        <div class="row d-flex justify-content-center">
          <div class="col-md-10 col-lg-9 col-xl-9">
            <div class="registeration-form">
              <form @submit.stop.prevent="Submit()" enctype="multipart/form-data">
                <div class="form-spacing">
                  <div class="half-form">
                    <div class="form-group mb-2 custom-form registeration-form-1">
                      <input
                        type="text"
                        name="subject"
                        class="form-control"
                        placeholder="First Name"
                        required
                        autofocus
                        v-model="signUpformObj.first_name"
                        :class="[{'is-invalid': errorFor('first_name')}]"
                      />
                      <v-errors :errors="errorFor('first_name')"></v-errors>
                    </div>
                    <div class="form-group mb-2 custom-form registeration-form-2">
                      <input
                        type="text"
                        name="subject"
                        class="form-control"
                        placeholder="Last Name"
                        required
                        v-model="signUpformObj.last_name"
                        :class="[{'is-invalid': errorFor('last_name')}]"
                      />
                      <v-errors :errors="errorFor('last_name')"></v-errors>
                    </div>
                  </div>

                  <div class="form-group mb-2 custom-form">
                    <input
                      type="email"
                      name="email"
                      class="form-control"
                      placeholder="Email"
                      required
                      v-model="signUpformObj.email"
                      :class="[{'is-invalid': errorFor('email')}]"
                    />
                    <v-errors :errors="errorFor('email')"></v-errors>
                  </div>

                  <div class="half-form">
                    <div class="form-group mb-2 custom-form registeration-form-1">
                      <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Password"
                        required
                        @input="matchPassword()"
                        v-model="signUpformObj.password"
                        :class="[{'is-invalid': errorFor('password')}]"
                      />
                      <v-errors :errors="errorFor('password')"></v-errors>
                      <transition-group name="fade" v-if="errors">
                        <p v-for="(error, keyIndex) in errors" :key="keyIndex+'from'">
                          <span v-if="error.password" style="color:#b22222">{{ error.password }}</span>
                        </p>
                      </transition-group>
                    </div>
                    <div class="form-group mb-2 custom-form registeration-form-2">
                      <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Confirm Password"
                        required
                        @input="matchPassword()"
                        v-model="signUpformObj.confirm_password"
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

                  <div class="form-group mb-2 custom-form">
                    <input
                      type="text"
                      name="text"
                      class="form-control"
                      placeholder="Phone"
                      required
                      v-model="signUpformObj.phone"
                      :class="[{'is-invalid': errorFor('phone')}]"
                    />
                    <v-errors :errors="errorFor('phone')"></v-errors>
                  </div>
                  <select
                    class="m-bottom registration-select freelaning-select"
                    required
                    v-model="signUpformObj.industry"
                    :class="[{'is-invalid': errorFor('industry')}]"
                  >
                    <option value>Prefered Industry</option>
                    <option
                      v-for="(data, index) of industries"
                      :key="index"
                      :value="data.id"
                    >{{data.title}}</option>
                  </select>
                  <v-errors :errors="errorFor('industry')"></v-errors>
                  <div class="form-group mb-2 custom-form">
                    <input
                      type="number"
                      name="text"
                      class="form-control"
                      placeholder="Price"
                      required
                      v-model="signUpformObj.price"
                      :class="[{'is-invalid': errorFor('price')}]"
                    />
                    <v-errors :errors="errorFor('price')"></v-errors>
                  </div>
                  <div class="row mt-3">
                    <div class="col-md-6 browser-content create-pic replace">
                      <div v-if="url && url.length">
                        <img :src="url?url:'/images/Untitled-1_10.jpg'" class="preview-image-width" />
                      </div>
                    </div>
                    <div class="col-md-6 tab-responsive">
                      <file-upload
                        class="btn-browser"
                        :post-action="postAction"
                        :extensions="extensions"
                        :accept="accept"
                        :multiple="multiple"
                        :directory="directory"
                        :size="size || 0"
                        :thread="thread < 1 ? 1 : (thread > 5 ? 5 : thread)"
                        v-model="signUpformObj.profile_picture"
                        @input-filter="inputFilter"
                        @input-file="inputFile"
                        ref="upload"
                      >BROWSER</file-upload>
                    </div>
                  </div>
                  <select
                    class="m-bottom-1 registration-select freelaning-select"
                    v-model="signUpformObj.experience"
                    required
                  >
                    <option value selected>Experience</option>
                    <option value="1-2 years">1-2 years</option>
                    <option value="2-5 years">2-5 years</option>
                    <option value="5-10 years">5-10 years</option>
                    <option value="More than 10 years">More than 10 years</option>
                  </select>

                  <select
                    class="registration-select freelaning-select"
                    v-model="signUpformObj.sales_method"
                    required
                  >
                    <option value>Preffered Sales Method:</option>
                    <option
                      v-for="(data, index) of sales_methods"
                      :key="index"
                      :value="data.id"
                    >{{data.title}}</option>
                  </select>

                  <div class="form-group mb-2 custom-form">
                    <input
                      type="text"
                      name="text"
                      class="form-control"
                      placeholder="Preffered Contact"
                      required
                      v-model="signUpformObj.primary_contact"
                      :class="[{'is-invalid': errorFor('primary_contact')}]"
                    />
                    <v-errors :errors="errorFor('primary_contact')"></v-errors>
                  </div>
                  <select
                    class="registration-select freelaning-select mb-4"
                    v-model="signUpformObj.source"
                  >
                    <option value>Select How Do You Find About Website?</option>
                    <option value="Google">Google</option>
                    <option value="Facebook">Facebook</option>
                    <option value="Linkedin">Linkedin</option>
                    <option value="Instagram">Instagram</option>
                    <option value="Twitter">Twitter</option>
                    <option value="Youtube">Youtube</option>
                    <option value="Refferal">Refferal</option>
                  </select>
                  <div class="form-group mb-2 custom-form">
                    <textarea
                      class="form-control foam-border comment-box"
                      placeholder="Enter Your Profile Description"
                      rows="6"
                      required
                      cols="50"
                      v-model="signUpformObj.description"
                      :class="[{'is-invalid': errorFor('description')}]"
                    ></textarea>
                    <v-errors :errors="errorFor('description')"></v-errors>
                  </div>
                  <div class="row mt-3">
                    <div class="col-md-12 registration-bottom freelanc-content">
                      <p>
                        Refferer Business Email Will Receive 10% Off Next Yearly Renewal Or Refer Freelance Profile Email And They Will
                        Receive Increase Rating.
                      </p>
                    </div>
                  </div>
                </div>
                <div class="form-group registration-contact freelancing-bottom">
                  <p>
                    <input
                      class="mr-3 register-checkbox"
                      type="checkbox"
                      v-model="signUpformObj.privacy"
                      required
                      :class="[{'is-invalid': errorFor('privacy')}]"
                    />
                    <span
                      class="cyan-words cursor-pointer"
                      data-toggle="modal"
                      data-target="#exampleModalScrollable"
                    >I’ve Read and I Accept terms and conditions.</span>.
                    <v-errors :errors="errorFor('privacy')"></v-errors>
                  </p>
                  <button class="btn-registration mt-4 ml-5" type="submit">Register</button>
                </div>
                <div class="alert alert-success alert-dismissible mt-4" v-if="isSuccess">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Success!</strong> Please Login.
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
    <terms-and-conditions></terms-and-conditions>
  </div>
</template>
<script>
import termsAndConditions from "../common/termsAndConditions";
import validationErrors from "../../mixins/validationErrors";
import { is422 } from "../../utils/response";
import { getSalesmethods, getIndustries } from "../../utils/getDatabseData";

export default {
  mixins: [validationErrors],
  components: {
    termsAndConditions,
  },

  data() {
    return {
      files: [],
      loader: true,
      url: null,
      accept: "image/png,image/gif,image/jpeg,image/webp",
      extensions: "gif,jpg,jpeg,png,webp",
      minSize: 1024,
      size: 1024 * 1024 * 10,
      multiple: false,
      directory: false,
      thread: 3,
      name: "file",
      postAction: "/index.php/api/user",
      putAction: "/index.php/api/user",
      autoCompress: 1024 * 1024,
      uploadAuto: false,

      isLoading: true,
      signUpformObj: {
        first_name: null,
        last_name: null,
        email: null,
        password: null,
        confirm_password: null,
        source: "",
        sales_method: "",
        profile_picture: [],
        industry: "",
        experience: "",
        price: null,
        primary_contact: null,
        description: null,
        role: "freelancer",
        privacy: null,
        phone: null,
      },
      sales_methods: null,
      industries: null,
      errors: null,
      status: null,
      isSuccess: false,
    };
  },
  watch: {
    "signUpformObj.profile_picture": function (val, oldVal) {
      if (
        this.signUpformObj.profile_picture &&
        this.signUpformObj.profile_picture[0] &&
        this.signUpformObj.profile_picture[0].blob
      ) {
        this.url = this.signUpformObj.profile_picture[0].blob;
      }
    },
  },
  computed: {
    hasErrors() {
      return 422 === this.status && this.errors !== null;
    },
  },
  async created() {
    this.industries = await getIndustries();
    this.sales_methods = await getSalesmethods();
    setTimeout(() => {
      this.loader = false;
    }, 1000);
  },
  methods: {
    // matching password
    matchPassword() {
      if (
        this.signUpformObj.password &&
        this.signUpformObj.confirm_password &&
        this.signUpformObj.password != this.signUpformObj.confirm_password
      ) {
        this.errors = [{ password: "password not matched" }];
        return;
      } else {
        return (this.errors = null);
      }
    },
    // form submit
    async Submit() {
      console.log(this.signUpformObj.profile_picture);
      this.loader = true;

      const data = new FormData();
      data.append("first_name", this.signUpformObj.first_name);
      data.append("last_name", this.signUpformObj.last_name);
      data.append("email", this.signUpformObj.email);
      data.append("password", this.signUpformObj.password);
      data.append("confirm_password", this.signUpformObj.confirm_password);
      data.append("source", this.signUpformObj.source);
      data.append("sales_method", this.signUpformObj.sales_method);
      data.append("industry", this.signUpformObj.industry);
      data.append("experience", this.signUpformObj.experience);
      data.append("price", this.signUpformObj.price);
      data.append("primary_contact", this.signUpformObj.primary_contact);
      data.append("description", this.signUpformObj.description);
      data.append("role", this.signUpformObj.role);
      data.append("phone", this.signUpformObj.phone);

      if (this.signUpformObj.profile_picture[0] != null) {
        data.append(
          "profile_picture",
          this.signUpformObj.profile_picture[0].file
        );
      }
      await axios
        .post("/index.php/api/user", data)
        .then((response) => {
          this.loader = false;
          if (response.status && response.status == 200) {
            this.isSuccess = true;
            setTimeout(() => {
              this.$router.push({ name: "home" });
            }, 2000);
          }
        })
        .catch((error) => {
          this.loader = false;
          if (is422(error)) {
            this.errors = error.response.data.errors;
          }
          this.status =
            error.response && error.response.status
              ? error.response.status
              : "";
        })
        .then(() => {
          this.loader = false;
        });
    },
    inputFilter(newFile, oldFile, prevent) {
      if (newFile && !oldFile) {
        // Add file

        // Filter non-image file
        // Will not be added to files
        if (!/\.(jpeg|jpe|jpg|gif|png|webp)$/i.test(newFile.name)) {
          return prevent();
        }
        // Create the 'blob' field for thumbnail preview
        newFile.blob = "";
        let URL = window.URL || window.webkitURL;
        if (URL && URL.createObjectURL) {
          newFile.blob = URL.createObjectURL(newFile.file);
        }
      }

      if (newFile && oldFile) {
        // Update file

        // Increase the version number
        if (!newFile.version) {
          newFile.version = 0;
        }
        newFile.version++;
      }

      if (!newFile && oldFile) {
        // Remove file
        // Refused to remove the file
        // return prevent()
      }
    },
    //
    // add, update, remove File Event
    inputFile(newFile, oldFile) {
      if (newFile && oldFile) {
        // update
        if (newFile.active && !oldFile.active) {
          // beforeSend
          // min size
          if (
            newFile.size >= 0 &&
            this.minSize > 0 &&
            newFile.size < this.minSize
          ) {
            this.$refs.upload.update(newFile, { error: "size" });
          }
        }
        if (newFile.progress !== oldFile.progress) {
          // progress
        }
        if (newFile.error && !oldFile.error) {
          // error
        }
        if (newFile.success && !oldFile.success) {
          // success
        }
      }
      if (!newFile && oldFile) {
        // remove
        if (oldFile.success && oldFile.response.id) {
          // $.ajax({
          //   type: 'DELETE',
          //   url: '/upload/delete?id=' + oldFile.response.id,
          // })
        }
      }
      // Automatically activate upload
      if (
        Boolean(newFile) !== Boolean(oldFile) ||
        oldFile.error !== newFile.error
      ) {
        if (this.uploadAuto && !this.$refs.upload.active) {
          this.$refs.upload.active = true;
        }
      }
    },
  },
};
</script>
<style scoped>
.display-none {
  display: none;
}
.cursor-pointer {
  cursor: pointer;
}
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>  