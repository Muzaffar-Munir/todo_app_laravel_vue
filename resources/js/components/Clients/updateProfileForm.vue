<template>
  <div>
    <div v-if="loader">
      <div class="spinner"></div>
    </div>
    <section class="register-sec-profile">
      <div class="container">
        <div class="row d-flex justify-content-center">
          <div class="col-md-10 col-lg-12 col-xl-12">
            <div class="registeration-form">
              <form @submit.stop.prevent="Submit()">
                <div class="form-spacing">
                  <div class="half-form">
                    <div class="form-group mb-2 custom-form registeration-form-1">
                      <input
                        type="text"
                        name="subject"
                        class="form-control"
                        placeholder="First Name"
                        v-model="updateFormObj.first_name"
                        required
                        autofocus
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
                        v-model="updateFormObj.last_name"
                        :class="[{'is-invalid': errorFor('last_name')}]"
                      />
                      <v-errors :errors="errorFor('last_name')"></v-errors>
                    </div>
                  </div>
                  <div class="form-group mb-2 custom-form">
                    <input
                      type="text"
                      name="text"
                      class="form-control"
                      placeholder="ABN/ACN"
                      required
                      v-model="updateFormObj.abn"
                      :class="[{'is-invalid': errorFor('abn')}]"
                    />
                    <v-errors :errors="errorFor('abn')"></v-errors>
                  </div>
                  <select
                    class="registration-select freelaning-select"
                    v-model="updateFormObj.sales_method"
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
                      placeholder="Address"
                      required
                      v-model="updateFormObj.address"
                      :class="[{'is-invalid': errorFor('address')}]"
                    />
                    <v-errors :errors="errorFor('address')"></v-errors>
                  </div>
                  <div class="form-group mb-2 custom-form">
                    <input
                      type="email"
                      name="email"
                      class="form-control"
                      placeholder="Email"
                      required
                      v-model="updateFormObj.email"
                      :class="[{'is-invalid': errorFor('email')}]"
                    />
                    <v-errors :errors="errorFor('email')"></v-errors>
                  </div>

                  <div class="form-group mb-2 custom-form">
                    <input
                      type="text"
                      name="text"
                      class="form-control"
                      placeholder="Phone"
                      required
                      v-model="updateFormObj.phone"
                      :class="[{'is-invalid': errorFor('phone')}]"
                    />
                    <v-errors :errors="errorFor('phone')"></v-errors>
                  </div>
                  <div class="form-group mb-2 custom-form">
                    <input
                      type="text"
                      name="text"
                      class="form-control"
                      placeholder="Business Name"
                      required
                      v-model="updateFormObj.business_name"
                      :class="[{'is-invalid': errorFor('business_name')}]"
                    />
                    <v-errors :errors="errorFor('business_name')"></v-errors>
                  </div>
                  <div class="form-group mb-2 custom-form">
                    <input
                      type="text"
                      name="text"
                      class="form-control"
                      placeholder="Business Address"
                      required
                      v-model="updateFormObj.business_address"
                      :class="[{'is-invalid': errorFor('business_address')}]"
                    />
                    <v-errors :errors="errorFor('business_address')"></v-errors>
                  </div>

                  <div class="row mt-4">
                    <div class="col-md-6 create-pic replace">
                      <div v-if="userData.user.profile_picture && !url">
                        <img
                          class="preview-image-width"
                          :src="userData.user.profile_picture ? '/images/users/'+userData.user.profile_picture : '/assets/images/Untitled-1_10.jpg'"
                        />
                      </div>
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
                        v-model="updateFormObj.profile_picture"
                        @input-filter="inputFilter"
                        @input-file="inputFile"
                        ref="upload"
                      >BROWSER</file-upload>
                    </div>
                  </div>
                </div>
                <div class="form-group registration-contact create-account-content">
                  <button class="btn-registration mt-4 ml-5" type="submit">Update</button>
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
import validationErrors from "../../mixins/validationErrors";
import { getSalesmethods } from "../../utils/getDatabseData";
import { is422 } from "../../utils/response";
export default {
  mixins: [validationErrors],
  props: ["userData"],
  data() {
    return {
      sales_methods: null,
      url: null,
      loader: false,
      isSuccess: false,
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
      errors: null,
      status: null,
      uploadAuto: false,
      updateFormObj: {
        first_name: this.userData.user.first_name,
        last_name: this.userData.user.last_name,
        email: this.userData.user.email,
        phone: this.userData.user.phone,
        address: this.userData.client.address,
        profile_picture: [this.userData.user.profile_picture],
        business_name: this.userData.client.business_name,
        business_address: this.userData.client.business_address,
        abn: this.userData.client.abn,
        sales_method: this.userData.user.sales_method,
      },
    };
  },
  watch: {
    "updateFormObj.profile_picture": function (val, oldVal) {
      if (
        this.updateFormObj.profile_picture &&
        this.updateFormObj.profile_picture[0] &&
        this.updateFormObj.profile_picture[0].blob
      ) {
        this.url = this.updateFormObj.profile_picture[0].blob;
      }
    },
  },
  methods: {
    // getting user to update localstorage
    async getUser() {
      const userObj = (
        await axios.get(
          "/index.php/api/user/" +
            this.userData.user.id +
            "?profile-details=true",
          {
            withCredentials: true,
          }
        )
      ).data;
      localStorage.setItem("current_user", JSON.stringify(userObj));
    },
    Submit() {
      this.loader = true;
      const data = new FormData();
      data.append("first_name", this.updateFormObj.first_name);
      data.append("last_name", this.updateFormObj.last_name);
      data.append("email", this.updateFormObj.email);
      data.append("phone", this.updateFormObj.phone);
      data.append("address", this.updateFormObj.address);
      data.append("business_name", this.updateFormObj.business_name);
      data.append("business_address", this.updateFormObj.business_address);
      data.append("abn", this.updateFormObj.abn);
      data.append("sales_method", this.updateFormObj.sales_method);      
      data.append("_method", "PATCH");
      if (
        this.updateFormObj.profile_picture[0] != null &&
        this.updateFormObj.profile_picture[0].file
      ) {
        data.append(
          "profile_picture",
          this.updateFormObj.profile_picture[0].file
        );
      }
      axios
        .post("/index.php/api/client/" + this.userData.client.id, data)
        .then((response) => {
          if (response.status == 200) {
            this.loader = false;
            this.getUser();
            this.$router.push({
              name: "create-service",
            });
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
  async created() {
    this.sales_methods = await getSalesmethods();
  },
};
</script>