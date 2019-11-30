<template>
 <div>
    <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Customer</h1>
          <p class="mb-4">
             <b-button id="show-btn" @click="showAddModal" class="btn btn-success" style="margin-top: 8px;">
                       <span class="fa fa-plus-circle"></span>
                     Add Customer</b-button>
          </p>

          <!-- add unit model start -->
                      <b-modal id="bv-modal-add-customer" hide-footer>
                        <template v-slot:modal-title>
                          {{modalForName}}
                        </template>
                        <div class="d-block">
                               <div class="form-group">
                                <input type="hidden" v-model="customer.id">
                                <label for="Name">Name:</label>
                                <input type="text" class="form-control" v-model="customer.name">
                              </div>
                              <div class="form-group">
                                <label for="Address">Address:</label>
                                <input type="text" class="form-control" v-model="customer.address">
                              </div>
                               <div class="form-group">
                                <label for="Phone">Phone:</label>
                                <input type="phone" class="form-control" v-model="customer.phone">
                              </div>
                        </div>
                        <b-button class="mt-3" block @click="callFunc">{{modalForName}}</b-button>
                      </b-modal>
            <!-- add unit modal end-->

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Customers</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Address</th>
                      <th>Phone</th>
                      <th>Updated at</th>
                      <th>Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="customer in customers" v-bind:key="customer.id">
                      <td>{{customer.id}}</td>
                      <td>{{customer.name}}</td>
                      <td>{{customer.address}}</td>
                      <td>{{customer.phone}}</td>
                      <td>{{customer.updated_at}}</td>

                      <td><button class="btn btn-outline-success" style="margin-right: 5px;" @click=editCustomer(customer.id)><span class="fa fa-edit"></span></button><button class="btn btn-outline-danger" @click=deleteCustomer(customer.id)><span class="fa fa-trash"></span></button></td>
                    </tr>
                  </tbody>
                </table>
              </div>

            </div>
          </div>
 </div>
</template>
<script>
  export default{

    data(){
      return {

        customers:[], //contains all the retrived units from the database

        customer:{}, //for form single unit data

        modalForName: "",
        modalForCode: 0 ,      

      }
    },
    created(){
      //this block will execute when component created
      this.fetchCustomers();
    },

    methods:{
      //methods codes here
      fetchCustomers(){

        let vm=this;// current pointer instance while going inside the another functional instance
        axios.get('/api/customers')
        .then(function(response){
          vm.customers=response.data.data;
        })
        .catch(function(error){
          console.log();
        });

        //above and below code provide same result but above code need current instance pointer for value assignmnent 

         //below code donot need current pointer to be save becasue it execute in current block rather then another block that need previous pointer.


        // axios.get('/api/customers')
        // .then(response=>{
        //   // console.log(response.data.data)
        //   this.customers=response.data.data
        // })
        // .catch(error=>{
        //   console.log(error)
        // })


      },
      showAddModal(){
        this.modalForName="Add Customer";
        // Vue.set(this.modalForName,"Add Unit");
        this.modalForCode=0; //0 for add 
        // Vue.set(this.modalForCode,0);
        this.$bvModal.show('bv-modal-add-customer')
      },
      callFunc(){

        if(this.modalForCode==0){
            this.addCustomer();
            // console.log("Add Unit");
        }
        else if(this.modalForCode==1){
            this.updateCustomer();
            // console.log("Edit Unit");
        }

      },
      addCustomer(){        
        let currObj=this;
        axios.post('/api/customer',this.customer)
        .then(function(response){
          currObj.output=response.data.msg;
          currObj.status=response.data.status;
          currObj.$swal('Info',currObj.output ,currObj.status);

          currObj.$bvModal.hide('bv-modal-add-customer');

          currObj.fetchCustomers();

        })
        .catch(function(error){
           currObj.output=error;
        });



      },
      editCustomer(id){
        let currObj=this;
        this.modalForName="Edit Customer";
        this.modalForCode=1;// 1 for Edit
        this.$bvModal.show('bv-modal-add-customer');

        axios.get('/api/customer/'+id)
        .then(response=>{
          // console.log(response.data.unit)
          Vue.set(this.customer, 'name', response.data.customer.name);
          Vue.set(this.customer, 'address', response.data.customer.address);
          Vue.set(this.customer, 'phone', response.data.customer.phone);
          Vue.set(this.customer, 'id', id);//to send id to the update controller 
        })
        .catch(error=>{
          console.log(error)
        })

      },
      updateCustomer(){

        let currObj=this;
        let formData= new FormData();
        formData.append('_method', 'PUT');//add this otherwise data won't pass to backend
        formData.append('name',this.customer.name);
        formData.append('address',this.customer.address);
        formData.append('phone',this.customer.phone);
        formData.append('id',this.customer.id);

        axios.post('/api/customer',formData)
        .then(function(response){
          currObj.output=response.data.msg;
          currObj.status=response.data.status;
          // alert(currObj.status);
           
                currObj.$swal('Info',currObj.output ,currObj.status);
                currObj.$bvModal.hide('bv-modal-add-customer');
                currObj.fetchCustomers();

        })
        .catch(function(error){
           currObj.output=error;
            // console.log(currObj.output);
        })



      },
      deleteCustomer(id){
        let currObj=this;
          this.$swal({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
          }).then((result)=>{

              if(result.value){
                  axios.delete('/api/customer/'+id)
                  .then(function(response){
                     currObj.output=response.data.msg;
                      currObj.status=response.data.status;
                      // alert(currObj.status);
                      currObj.$swal('Info',currObj.output ,currObj.status);
                      currObj.fetchCustomers();

                  }).catch(function(error){
                     currObj.output=error;
                    console.log(currObj.output);
                  })

              }


          });


      }//end of deleteUnit()



    //end of methods block
    }

  }
</script>
