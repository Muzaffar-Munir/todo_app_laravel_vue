<template>
  <div>
     <section  v-if="userObj">

    <div class="row view-ads view-profile create-account-profile">
      <div class="col-md-6">
        <img
          :src="userObj.user.profile_picture ? '/images/users/'+userObj.user.profile_picture: '/assets/images/thumbnail-user.jpg'"
        />
      </div>
      <div class="col-md-6">
        <div class="image-content profile-content">
          <p class="name">{{userObj.user.full_name ? userObj.user.full_name : ''}}</p>
          <p class="work" v-if="userObj.freelancer.industries">{{userObj.freelancer.industries.title ? userObj.freelancer.industries.title :'' }}</p>

          <h2>INDUSTRY</h2>
          <p v-if="userObj.freelancer.industries">{{userObj.freelancer.industries.title ? userObj.freelancer.industries.title :'' }}</p>
           <h2>PRICE</h2>
          <p v-if="userObj.freelancer.price">{{userObj.freelancer.price }}</p>

          <h2>SALES METHOD</h2>
          <p v-if="userObj.user && userObj.user.salesmethods">{{userObj.user.salesmethods.title ? userObj.user.salesmethods.title :'' }}</p>

          <h2>CONTACT DETAILS</h2>
          <p>EMAIL: {{userObj.user.email ? userObj.user.email : ''}}</p>
          <p>CONTACT: {{userObj.user.phone ? userObj.user.phone : ''}}</p>
        </div>
      </div>

      <div class="col-md-12">
        <h2>DESCRIPTION</h2>
        <p>{{userObj.freelancer.description ? userObj.freelancer.description : ''}}</p>
      </div>
    </div>
    </section>
  </div>
</template>
<script>
export default {
  props: ["id", "userObj"],
};
</script>