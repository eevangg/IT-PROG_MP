document.addEventListener('DOMContentLoaded', function() {
    // Toggle order item row
  document.addEventListener("click", (e) => {
    const toggleBtn = e.target.closest(".toggleItems");
     if (!toggleBtn) return;
 
     const id = toggleBtn.dataset.id;
     const icon = toggleBtn.querySelector("i");
     const row = document.getElementById(`item-${id}`);
 
     // Close all other opened rows (both passengers and routes)
     document.querySelectorAll(".items-row").forEach((r) => {
       if (r.id !== `item-${id}`) {
            r.classList.add("d-none");
       }
     });
 
     // Reset all other icons to closed state
     document.querySelectorAll(".toggleItems i").forEach((i) => {
       if (i !== icon) {
        i.classList.remove("bi-caret-up");
        i.classList.add("bi-caret-down");
       }
     });
 
     // Toggle the clicked one
     const isOpen = !row.classList.contains("d-none");
     row.classList.toggle("d-none", isOpen); // close if open, open if closed
     icon.classList.toggle("bi-caret-down", isOpen);
     icon.classList.toggle("bi-caret-up", !isOpen);
   });

   function showToast(message, success = true) {
        const toastEl = document.getElementById("toast");
        const toastBody = document.getElementById("toastBody");
        if (!toastEl || !toastBody) return;
    
        toastEl.classList.remove("bg-danger", "bg-success");
        toastEl.classList.add(success ? "bg-success" : "bg-danger");
        toastBody.textContent = message;
    
        new bootstrap.Toast(toastEl, { delay: 2500 }).show();
  }
 

   //  Inline status and payment status edit: enter edit mode
    document.addEventListener("click", (e) => {
        const editBtn = e.target.closest(".editStatusBtn, .editPaymentBtn");
        if (!editBtn) return;   

        const id = editBtn.dataset.id;
        const type = editBtn.dataset.type; // 'status' or 'payment'

        // close all other edit modes
        document.querySelectorAll(".status-edit, .payment-edit").forEach((row) => {
            row.classList.add("d-none");
        });

        if (type === 'status') {
            document.getElementById(`statusDisplay-${id}`).classList.add("d-none");
            document.getElementById(`statusEdit-${id}`).classList.remove("d-none");
        } else if (type === 'payment') {
            document.getElementById(`paymentDisplay-${id}`).classList.add("d-none");
            document.getElementById(`paymentEdit-${id}`).classList.remove("d-none");
        }
    });
    
    //  Inline status and payment edit: cancel
    document.addEventListener("click", (e) => {
        const cancelBtn = e.target.closest(".cancelPaymentBtn, .cancelStatusBtn");
        if (!cancelBtn) return;

        const id = cancelBtn.dataset.id;
        const type = cancelBtn.dataset.type; // 'status' or 'payment'
        if (type === 'payment') {
            document.getElementById(`paymentEdit-${id}`).classList.add("d-none");
            document.getElementById(`paymentDisplay-${id}`).classList.remove("d-none");
        } else if (type === 'status') {
            document.getElementById(`statusEdit-${id}`).classList.add("d-none");
            document.getElementById(`statusDisplay-${id}`).classList.remove("d-none");
        }
    });
  
    //  Inline status and payment edit: save changes
    document.addEventListener("click", async (e) => {
        const saveBtn = e.target.closest(".saveStatusBtn, .savePaymentBtn");
        if (!saveBtn) return;

        const id = saveBtn.dataset.id;
        const type = saveBtn.dataset.type; // 'status' or 'payment'
        let newValue;
        let payload = { 
            order_id: id,
            type: type
        };

        if (type === 'status') {
            newValue = document.getElementById(`statusSelect-${id}`).value;
            payload.status = newValue;
        } else if (type === 'payment') {
            newValue = document.getElementById(`paymentSelect-${id}`).value;
            payload.payment_status = newValue;
        }

        try {
            const response = await fetch('../processes/update_order.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(payload),
            });
            const data = await response.json();

            if (data.status === 'success') {
                if (type === 'status') {
                     // Update display badge
                    const display = document.getElementById(`statusDisplay-${id}`);
                    const edit = document.getElementById(`statusEdit-${id}`);
                    const badge = display.querySelector(".status-badge");

                    badge.className = "badge";
                    if (newValue === "completed" || newValue === "ready") badge.classList.add("bg-success");
                    else if (newValue === "cancelled") badge.classList.add("bg-danger");
                    else if (newValue === "pending" || newValue === "preparing") badge.classList.add("bg-secondary");
                    else badge.classList.add("bg-warning text-dark");

                    badge.textContent = newValue;

                    edit.classList.add("d-none");
                    display.classList.remove("d-none");
                    showToast(data.message, true);
                } else if (type === 'payment') {
                    // Update display badge
                    const display = document.getElementById(`paymentDisplay-${id}`);
                    const edit = document.getElementById(`paymentEdit-${id}`);
                    const badge = display.querySelector(".payment-badge");

                    badge.className = "badge";
                    if (newValue === "paid") badge.classList.add("bg-success");
                    else if (newValue === "unpaid") badge.classList.add("bg-danger");
                    else badge.classList.add("bg-warning text-dark");

                    badge.textContent = newValue;

                    edit.classList.add("d-none");
                    display.classList.remove("d-none");
                    showToast(data.message, true);
                }
            } else {
                showToast(data.message , false);
            }
        } catch (error) {
            console.error('Error:', error);
            showToast('An error occurred while updating the order.', false); 
        }
    });

});