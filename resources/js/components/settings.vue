<template>
 <div>
    <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Settings</h1>
          <!-- Setting -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Settings</h6>
            </div>
            <div class="card-body">
              <div class="row">
               <div class="col-md-4">  
                  <form @submit="formSubmit" enctype="multipart/form-data">
                    <div class="form-group">
                      <label>Company Name</label>
                      <input type="text" :class="['form-control']" placeholder="Company Name" v-model="settings.company_name">
                      <span v-if="errors.company_name" :class="['errorText']">{{ errors.company_name[0] }}</span>
                    </div>
                    <div class="form-group">
                      <label>Company Email</label>
                      <input type="text" :class="['form-control']" placeholder="Company Email" v-model="settings.company_email">
                      <span v-if="errors.company_email" :class="['errorText']">{{ errors.company_email[0] }}</span>
                    </div>
                    <div class="form-group">
                      <label>Company Address</label>
                      <input type="text" :class="['form-control']" placeholder="Company Address" v-model="settings.company_address">
                      <span v-if="errors.company_address" :class="['errorText']">{{ errors.company_address[0] }}</span>
                    </div>
                    <div class="form-group">
                      <label>Company Phone</label>
                      <input type="phone" :class="['form-control']" placeholder="Company Phone" v-model="settings.company_phone">
                      <span v-if="errors.company_phone" :class="['errorText']">{{ errors.company_phone[0] }}</span>
                    </div>
                     <div class="form-group">
                      <label>Tax Percentage</label>
                      <input type="number" :class="['form-control']" placeholder="Tax Percentage" v-model="settings.tax">
                      <span v-if="errors.tax" :class="['errorText']">{{ errors.tax[0] }}</span>
                    </div>
                    <div class="form-group">
                      <label>Company Website</label>
                      <input type="text" :class="['form-control']" placeholder="http://example.com" v-model="settings.company_url">
                      <span v-if="errors.company_url" :class="['errorText']">{{ errors.company_url[0] }}</span>
                    </div>
                     <div class="form-group">
                      <label>Company Logo</label>
                      <input type="file" :class="['form-control']" v-on:change="fileSelected">
                      <span v-if="errors.image" :class="['errorText']">{{ errors.image[0] }}</span>
                    </div>
                   
                    <button class="btn btn-primary">Save</button>
                </form>
            </div>
            <div class="col-md-3"></div>
              <div class="col-md-5">
                    <div class="card" style="width: 18rem;">
                      <img class="card-img-top image" v-bind:src="settings.company_logo" alt="Card image cap">
                      <div class="card-body">
                        <h4 style="text-align: center;">{{settings.company_name}}</h4>
                        <p class="card-text" style="text-align: center;">{{settings.company_address}}</p>
                        <p class="card-text" style="text-align: center;">{{settings.company_phone}}</p>
                        <p class="card-text" style="text-align: center;">{{settings.tax}}% TAX</p>
                      </div>
                    </div>
              </div>
            </div>
          </div><!-- end of card body -->
          </div>
  </div>
</template>
<style>
  .image{
    margin: 0 auto;
    width: 225px;
    height: 225px;
  }
</style>
<script>
  export default{

    data(){
      
      return {
          //list of data goes here

            settings:{},
            image:'',
            selectedFile:'',

            errors: [],



      };//end of return block inside of data block

    },//end of data block

    created(){
   
     this.fetchSettings();

    },


    methods:{
      //list of methods goes here
      fetchSettings(){

        fetch('api/settings/')
        .then(response=>response.json())
        .then(data=>(

              Vue.set(this.settings, 'id', data.settings.id),
              Vue.set(this.settings, 'company_name', data.settings.company_name),
              Vue.set(this.settings, 'company_email', data.settings.company_email),
              Vue.set(this.settings, 'company_address', data.settings.company_address),
              Vue.set(this.settings, 'company_phone', data.settings.company_phone),
              Vue.set(this.settings, 'company_url', data.settings.company_url),
              //company image
              Vue.set(this.settings, 'company_logo',"/img/"+ data.settings.company_logo),
              // this.company_logo="/img/"+data.settings.company_logo //concatenate image location and image name

              Vue.set(this.settings, 'tax', data.settings.tax)
              // console.log(data.settings.company_name)
          ));
      },//end of fetchSettings()

      fileSelected(e){
          // alert("File Selected");
          this.image=e.target.files[0];
          //console.log(this.image);

      },//end of fileSelected
      formSubmit(e){
        e.preventDefault();
        let currObj=this;

        const config={
          headers:{'content-type':'multipart/form-data'},

        }
        let formData= new FormData();
        formData.append('image',this.image);
        formData.append('_method', 'PUT');//add this otherwise data won't pass to backend
        formData.append('id',this.settings.id);
        formData.append('company_name',this.settings.company_name);
        formData.append('company_email',this.settings.company_email);
        formData.append('company_address',this.settings.company_address);
        formData.append('company_phone',this.settings.company_phone);
        formData.append('company_url',this.settings.company_url);
        formData.append('tax',this.settings.tax);
        // Display the key/value pairs
   
        // posting data //using post and sending form data as PUT to match the api route name setting
        axios.post('/api/settings',formData,config)
        .then(function (response){
          currObj.output=response.data.msg;
          currObj.status=response.data.status;
          // alert(currObj.status);
           
                currObj.$swal('Info',currObj.output ,currObj.status);

                currObj.fetchSettings();
                      

        })
        .catch(function(error){
              if (error.response.status == 422){
             currObj.validationErrors = error.response.data.errors;    
             currObj.errors = currObj.validationErrors;
             // console.log(currObj.errors);
            }   
        });

      }//end of formSubmit

    }//end of methods block




  }
</script>
