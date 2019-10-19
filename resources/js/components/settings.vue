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
                  <form>
                    <div class="form-group">
                      <label>Company Name</label>
                      <input type="text" class="form-control" placeholder="Company Name" v-model="settings.company_name">
                    </div>
                    <div class="form-group">
                      <label>Company Email</label>
                      <input type="text" class="form-control" placeholder="Company Email" v-model="settings.company_email">
                    </div>
                    <div class="form-group">
                      <label>Company Address</label>
                      <input type="text" class="form-control" placeholder="Company Address" v-model="settings.company_address">
                    </div>
                    <div class="form-group">
                      <label>Company Phone</label>
                      <input type="phone" class="form-control" placeholder="Company Phone" v-model="settings.company_phone">
                    </div>
                     <div class="form-group">
                      <label>VAT Percentage</label>
                      <input type="number" class="form-control" placeholder="VAT Percentage" v-model="settings.vat">
                    </div>
                    <div class="form-group">
                      <label>Company Website</label>
                      <input type="text" class="form-control" placeholder="http://example.com" v-model="settings.company_url">
                    </div>
                     <div class="form-group">
                      <label>Company Logo</label>
                      <input type="file" class="form-control" v-on:change="fileSelected">
                    </div>
                   
                    <button class="btn btn-primary">Save</button>
                </form>
            </div>
            <div class="col-md-3"></div>
              <div class="col-md-5">
                    <div class="card" style="width: 18rem;">
                      <img class="card-img-top company_logo" v-bind:src="settings.company_logo" alt="Card image cap">
                      <div class="card-body">
                        <h4 style="text-align: center;">{{settings.company_name}}</h4>
                        <p class="card-text" style="text-align: center;">{{settings.company_address}}</p>
                        <p class="card-text" style="text-align: center;">{{settings.company_phone}}</p>
                        <p class="card-text" style="text-align: center;">{{settings.vat}}% VAT</p>
                      </div>
                    </div>
              </div>
            </div>
          </div><!-- end of card body -->
          </div>
  </div>
</template>
<style>
  .company_logo{
    margin: 0 auto;
    width: 100px;
    height: 100px;
  }
</style>
<script>
  export default{

    data(){
      
      return {
          //list of datas goes here

            settings:{},
            company_logo:'',
            selectedFile:''



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

              Vue.set(this.settings, 'vat', data.settings.vat)
              // console.log(data.settings.company_name)


          ));
      },//end of fetchSettings()
      fileSelected(e){
          alert("File Selected");

      }//end of fileSelected


    }//end of methods block




  }
</script>
