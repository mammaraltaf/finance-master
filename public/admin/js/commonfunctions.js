function getRequestById(id){
 return $.ajax({
        url:`/request-detail/${id}`,
        type:"GET",
        cache:false,
        error:(err=>console.log(err))
    }).then(response=>{
            let innerHtml="";
                innerHtml+=`<p>Initiator: ${response?.initiator}</p>`;
                innerHtml+=`<p>Role: ${response?.user?.user_type }</p>`;
                innerHtml+=`<p>Created At: ${new Date(response?.created_at)?.toLocaleString()}</p>`;
                innerHtml+=`<p>Company: ${response?.company?.name}</p>`;
                innerHtml+=`<p>Department: ${response?.department?.name}</p>`;
                innerHtml+=`<p>Supplier: ${response?.supplier?.supplier_name}</p>`;
                innerHtml+=`<p>Type Of Expense: ${response?.type_of_expense?.name}</p>`;
                innerHtml+=`<p>Currency: ${response?.currency}</p>`;
                innerHtml+=`<p>Amount: ${response?.amount}</p>`;
                innerHtml+=`<p>Amount In Gel: ${response?.amount_in_gel}</p>`;
                innerHtml+=`<p>Description: ${response?.description}</p>`;
                innerHtml+=`<p>Link: <a href=${`"${response?.request_link}"`} target="_blank">${response?.request_link} </a></p>`;
                innerHtml+=`<p>Basis: <a href=${`"${response?.basis}"`} target="_blank">${response?.basis} </a> </p>`;
                innerHtml+=`<p>Comment: ${response?.comment}</p>`;
                innerHtml+=`<p>Request Status: ${response?.status}</p>`;
                innerHtml+=`<p>User Action: ${response?.lastUserWhoTookAction}</p>`;
     return innerHtml;
    })
}

function getLogById(id){
return $.ajax({
        url:`/log-detail/${id}`,
        type:"GET",
        cache:false,
        error:(err=>console.log(err))
    }).then(response=>{
        console.log(response);
            let innerHtml="";
                innerHtml+=`<p>Initiator: ${response?.initiator}</p>`;
                innerHtml+=`<p>Role: ${response?.user?.user_type }</p>`;
                innerHtml+=`<p>Created At: ${new Date(response?.created_at)?.toLocaleString()}</p>`;
                innerHtml+=`<p>Company: ${response?.company?.name}</p>`;
                innerHtml+=`<p>Department: ${response?.department?.name}</p>`;
                innerHtml+=`<p>Supplier: ${response?.supplier?.supplier_name}</p>`;
                innerHtml+=`<p>Type Of Expense: ${response?.type_of_expense?.name}</p>`;
                innerHtml+=`<p>Currency: ${response?.currency}</p>`;
                innerHtml+=`<p>Amount: ${response?.amount}</p>`;
                innerHtml+=`<p>Amount In Gel: ${response?.amount_in_gel}</p>`;
                innerHtml+=`<p>Description: ${response?.description}</p>`;
                innerHtml+=`<p>Link: <a href=${`"${response?.request_link}"`} target="_blank">${response?.request_link} </a></p>`;
                innerHtml+=`<p>Basis: <a href=${`"${response?.basis}"`} target="_blank">${response?.basis} </a> </p>`;
                innerHtml+=`<p>Comment: ${response?.comment}</p>`;
                return innerHtml;
    })
}
