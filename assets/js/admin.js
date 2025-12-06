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


   // Function to show toast notifications
   function showToast(message, success = true) {
        const toastEl = document.getElementById("toast");
        const toastBody = document.getElementById("toastBody");
        if (!toastEl || !toastBody) return;
    
        toastEl.classList.remove("bg-danger", "bg-success");
        toastEl.classList.add(success ? "bg-success" : "bg-danger");
        toastBody.textContent = message;
    
        new bootstrap.Toast(toastEl, { delay: 2500 }).show();
  }

  // function to show delete confirmation toast
  function showDeleteToast(message) {
        const deleteToastEl = document.getElementById("deleteToast");
        const deleteToastAlert = deleteToastEl.querySelector("#deleteToastAlert");
        if (!deleteToastEl || !deleteToastAlert) return;

        deleteToastAlert.innerHTML = message;
    
       // Show toast
        const toast = new bootstrap.Toast(deleteToastEl, { delay: 5000 });
        toast.show();
  }
 


   //  Inline order status, payment status, meal plans status, and menu item status edit: enter edit mode
    document.addEventListener("click", (e) => {
        const editBtn = e.target.closest(".editStatusBtn, .editPaymentBtn, .editItemStatusBtn, .editPlanStatusBtn");
        if (!editBtn) return;   

        const id = editBtn.dataset.id;
        const type = editBtn.dataset.type; // 'status', 'payment',  'itemStatus' or 'planStatus'

        // close all other edit modes
        document.querySelectorAll(".status-edit, .payment-edit, .item-edit, .plan-edit").forEach((row) => {
            row.classList.add("d-none");
            // show all display modes
            document.querySelectorAll(".status-display, .payment-display, .item-display, .plan-display").forEach((disp) => {
                disp.classList.remove("d-none");
            });
        });

        if (type === 'status') {
            document.getElementById(`statusDisplay-${id}`).classList.add("d-none");
            document.getElementById(`statusEdit-${id}`).classList.remove("d-none");
        } else if (type === 'payment') {
            document.getElementById(`paymentDisplay-${id}`).classList.add("d-none");
            document.getElementById(`paymentEdit-${id}`).classList.remove("d-none");
        }else if (type === 'itemStatus') {
            document.getElementById(`itemDisplay-${id}`).classList.add("d-none");
            document.getElementById(`itemEdit-${id}`).classList.remove("d-none");
        } else if (type === 'planStatus') {
            document.getElementById(`planDisplay-${id}`).classList.add("d-none");
            document.getElementById(`planEdit-${id}`).classList.remove("d-none");
        }
    });
    

    // Inline order status, payment status, meal plans status, and menu item status edit: cancel
    document.addEventListener("click", (e) => {
        const cancelBtn = e.target.closest(".cancelPaymentBtn, .cancelStatusBtn, .cancelItemStatusBtn, .cancelPlanStatusBtn");
        if (!cancelBtn) return;

        const id = cancelBtn.dataset.id;
        const type = cancelBtn.dataset.type; // 'status', 'payment', 'itemStatus' or 'planStatus'
        if (type === 'payment') {
            document.getElementById(`paymentEdit-${id}`).classList.add("d-none");
            document.getElementById(`paymentDisplay-${id}`).classList.remove("d-none");
        } else if (type === 'status') {
            document.getElementById(`statusEdit-${id}`).classList.add("d-none");
            document.getElementById(`statusDisplay-${id}`).classList.remove("d-none");
        } else if (type === 'itemStatus') {
            document.getElementById(`itemEdit-${id}`).classList.add("d-none");
            document.getElementById(`itemDisplay-${id}`).classList.remove("d-none");
        } else if (type === 'planStatus') {
            document.getElementById(`planEdit-${id}`).classList.add("d-none");
            document.getElementById(`planDisplay-${id}`).classList.remove("d-none");
        }   
    });
  

    //  Inline order status, payment status, meal plan status, and menu item status edit: save changes
    document.addEventListener("click", async (e) => {
        const saveBtn = e.target.closest(".saveStatusBtn, .savePaymentBtn, .saveItemStatusBtn, .savePlanStatusBtn");
        if (!saveBtn) return;

        const id = saveBtn.dataset.id;
        const type = saveBtn.dataset.type; // 'status', 'payment', 'itemStatus' or 'planStatus'
        let newValue;
        let payload = { 
            id: id,
            type: type
        };


        if (type === 'status') {
            newValue = document.getElementById(`statusSelect-${id}`).value;
            payload.status = newValue;
        } else if (type === 'payment') {
            newValue = document.getElementById(`paymentSelect-${id}`).value;
            payload.payment_status = newValue;
        } else if (type === 'itemStatus') {
            newValue = document.getElementById(`itemStatusSelect-${id}`).value;
            payload.item_status = newValue;
        } else if (type === 'planStatus') {
            newValue = document.getElementById(`planStatusSelect-${id}`).value;
            payload.plan_status = newValue;
        }
    
        try {
            const response = await fetch('../../processes/admin-processes/update_status.php', {
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

                    badge.className = "badge status-badge";
                    if (newValue === "completed" || newValue === "ready") badge.classList.add("bg-success");
                    else if (newValue === "cancelled") badge.classList.add("bg-danger");
                    else if (newValue === "pending" || newValue === "preparing") badge.classList.add("bg-secondary");
                    else if (newValue === "confirmed"){badge.classList.add("bg-warning"); badge.classList.add("text-dark");};

                    badge.textContent = newValue;

                    edit.classList.add("d-none");
                    display.classList.remove("d-none");
                    showToast(data.message, true);

                } else if (type === 'payment') {
                    // Update display badge
                    const display = document.getElementById(`paymentDisplay-${id}`);
                    const edit = document.getElementById(`paymentEdit-${id}`);
                    const badge = display.querySelector(".payment-badge");

                    badge.className = "badge payment-badge";
                    if (newValue === "paid") badge.classList.add("bg-success");
                    else if (newValue === "failed") badge.classList.add("bg-danger");
                    else if (newValue === "refunded") badge.classList.add("bg-secondary");
                    else if (newValue === "pending") {badge.classList.add("bg-warning"); badge.classList.add("text-dark");};

                    badge.textContent = newValue;

                    edit.classList.add("d-none");
                    display.classList.remove("d-none");
                    showToast(data.message, true);
                } else if (type === 'itemStatus') {
                    // Update display badge
                    const display = document.getElementById(`itemDisplay-${id}`);
                    const edit = document.getElementById(`itemEdit-${id}`);
                    const badge = display.querySelector(".item-badge");

                    badge.className = "badge item-badge";
                    if (newValue === "active") badge.classList.add("bg-success");
                    else if (newValue === "inactive") badge.classList.add("bg-secondary");

                    badge.textContent = newValue;

                    edit.classList.add("d-none");
                    display.classList.remove("d-none");
                    showToast(data.message, true);
                } else if (type === 'planStatus') {
                    // Update display badge
                    const display = document.getElementById(`planDisplay-${id}`);
                    const edit = document.getElementById(`planEdit-${id}`);
                    const badge = display.querySelector(".plan-badge");

                    badge.className = "badge plan-badge";
                    if (newValue === "available") badge.classList.add("bg-success");
                    else if (newValue === "unavailable") badge.classList.add("bg-secondary");

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
            showToast('An error occurred while updating status.', false); 
        }
    });


    // user search filter
    const filters = document.querySelectorAll('#userFilter');
    if (filters.length > 0) {
        filters.forEach(filter => {

            filter.addEventListener('keyup', function () {
                const query = this.value.toLowerCase();

                const rows = document.querySelectorAll(`.usersTable tr`);
            
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(query) ? '' : 'none';
                });
               
            });
        });
    }
    // Universal table filter
    document.querySelectorAll('[data-table]').forEach(input => {
        if (input.id === 'orderFilter') return; // custom logic below focuses on order id

        input.addEventListener('keyup', function () {
            const query   = this.value.toLowerCase();
            const tableId = this.dataset.table;

            const rows = document.querySelectorAll(`#${tableId} tr`);
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });
    });

    // Order filter: prioritize matching the first column (Order ID), but allow fallback text search for non-numeric queries.
    const orderFilter = document.getElementById('orderFilter');
    if (orderFilter) {
        orderFilter.addEventListener('keyup', function () {
            const query = this.value.trim().toLowerCase();
            const rows = document.querySelectorAll('#ordersTable tr');
            const numericQuery = /^\d+$/.test(query);

            rows.forEach(row => {
                const firstCell = row.querySelector('td');
                const idText = firstCell ? firstCell.textContent.toLowerCase() : '';
                const rowText = row.textContent.toLowerCase();

                const matchesId = query === '' || idText.includes(query);
                const matchesFallback = !numericQuery && rowText.includes(query);

                row.style.display = (matchesId || matchesFallback) ? '' : 'none';
            });
        });
    }


    // Handle delete order and delete menu item
    let deleteTarget = { id: null, action: null };

    document.addEventListener("click", async (e) => {
        const deleteBtn = e.target.closest(".deleteOrderBtn, .deleteItemBtn, .deletePlanBtn");
        if (!deleteBtn) return;

        const id = deleteBtn.dataset.id;
        const action = deleteBtn.dataset.action; // 'delete_order' or 'delete_menu'

        deleteTarget.id = id;
        deleteTarget.action = action;

        if (action === 'delete_order') {
            showDeleteToast('<p>Are you sure you want to delete this order?</p><p>This action cannot be undone.</p>');
        }

        if (action === 'delete_menu') {
            showDeleteToast('<p>Are you sure you want to delete this menu item?</p><p>This action cannot be undone.</p>');
        }

        if (action === 'delete_plan') {
            showDeleteToast('<p>Are you sure you want to delete this meal plan?</p><p>This action cannot be undone.</p>');
        }
    });

    // Confirm delete
    const confirmDelete = document.getElementById("deleteForm");
    if (confirmDelete) {
        confirmDelete.addEventListener("submit", async (e) => {
            e.preventDefault();

            if (!deleteTarget.id || !deleteTarget.action) return;

            const payload = {
                action: deleteTarget.action,
            };
        
            if (deleteTarget.action === 'delete_order') {
                payload.order_id = deleteTarget.id;
            } else if (deleteTarget.action === 'delete_menu') {
                payload.item_id = deleteTarget.id;
            } else if (deleteTarget.action === 'delete_plan') {
                payload.plan_id = deleteTarget.id;
            }

            try {
                const response = await fetch('../../processes/admin-processes/process_delete.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload),
                });
        
                const data = await response.json();
        
                if (data.status === 'success') {
                    if (deleteTarget.action === 'delete_order') {
                        document.getElementById(`order-${deleteTarget.id}`)?.remove();
                        document.getElementById(`item-${deleteTarget.id}`)?.remove();

                        // update order count
                        const orderCountEl = document.getElementById('orderCount');
                        if (orderCountEl) {
                            let count = parseInt(orderCountEl.textContent);
                            count = isNaN(count) ? 0 : count - 1;
                            orderCountEl.textContent = count;
                        }
                    }
        
                    if (deleteTarget.action === 'delete_menu') {
                        document.getElementById(`menu-${deleteTarget.id}`)?.remove();

                        // update menu count
                        const menuCountEl = document.getElementById('menuCount');
                        if (menuCountEl) {
                            let count = parseInt(menuCountEl.textContent);
                            count = isNaN(count) ? 0 : count - 1;
                            menuCountEl.textContent = count;
                        }
                    }

                    if (deleteTarget.action === 'delete_plan') {
                        document.getElementById(`plan-${deleteTarget.id}`)?.remove();

                        // update plan count
                        const planCountEl = document.getElementById('mealPlanCount');
                        if (planCountEl) {
                            let count = parseInt(planCountEl.textContent);
                            count = isNaN(count) ? 0 : count - 1;
                            planCountEl.textContent = count;
                        }
                    }
        
                    showToast(data.message, true);
                } else {
                    showToast(data.message, false);
                }
        
            } catch (error) {
                console.error('Error:', error);
                showToast('An error occurred while deleting.', false);
            }

            const deleteToastEl = document.getElementById("deleteToast");
            const toastInstance = bootstrap.Toast.getInstance(deleteToastEl);
            if (toastInstance) toastInstance.hide();
        
            // Clear target
            deleteTarget = { id: null, action: null };
        });
    }
       


    // Handle create menu item form submission
    menuForm = document.getElementById("createMenuForm");
    if (menuForm) {
        menuForm.addEventListener("submit", async function(e) {
            e.preventDefault();

            // validate form inputs
            if (!this.checkValidity()) {
                e.stopPropagation();
                this.classList.add('was-validated');
                return;
            }

            // Prepare form data
            const formData = new FormData(menuForm);

            try {
                const response = await fetch('../../processes/admin-processes/process_create_menu.php', {
                    method: 'POST',
                    body: formData,
                });

                const data = await response.json();

                if (data.status === 'success') {
                    menuForm.reset();
                    showToast(data.message, true);

                } else {
                    showToast(data.message, false);
                }

            } catch (error) {
                console.error('Error:', error);
                showToast('An error occurred while creating the menu item.', false);
            }
        });
    }


    // Handle edit menu item form submission
    const editMenuForm = document.getElementById("editMenuForm");
    if (editMenuForm) { 
        editMenuForm.addEventListener("submit", async function(e) {
            e.preventDefault();

            // validate form inputs
            if (!this.checkValidity()) {
                e.stopPropagation();
                this.classList.add('was-validated');
                return;
            }

            // Prepare form data
            const formData = new FormData(editMenuForm);

            try {
                const response = await fetch('../../processes/admin-processes/process_edit_menu.php', {
                    method: 'POST',
                    body: formData,
                });

                const data = await response.json();

                if (data.status === 'success') {
                    showToast(data.message, true);
                    setTimeout(() => {
                        window.location.href = "manage_menu.php";
                    }, 1000);
                } else {
                    showToast(data.message, false);
                }

            } catch (error) {
                console.error('Error:', error);
                showToast('An error occurred while editing the menu item.', false);
            }
        });
    }

    
    // Handle create meal plan form submission
    const planForm = document.getElementById("createMealPlanForm");
    if (planForm) {
        planForm.addEventListener("submit", async function(e) {
            e.preventDefault();

            // validate form inputs
            if (!this.checkValidity()) {
                e.stopPropagation();
                this.classList.add('was-validated');
                return;
            }

            // Prepare form data
            const formData = new FormData(planForm);

            try {
                const response = await fetch('../../processes/admin-processes/process_create_meal_plan.php', {
                    method: 'POST',
                    body: formData,
                });

                const data = await response.json();

                if (data.status === 'success') {
                    planForm.reset();
                    showToast(data.message, true);

                } else {
                    showToast(data.message, false);
                }

            } catch (error) {
                console.error('Error:', error);
                showToast('An error occurred while creating the meal plan.', false);
            }
        });
    }


    // Handle edit meal plan form submission
    const editPlanForm = document.getElementById("editMealPlanForm");
    if (editPlanForm) { 
        editPlanForm.addEventListener("submit", async function(e) {
            e.preventDefault();

            // validate form inputs
            if (!this.checkValidity()) {
                e.stopPropagation();
                this.classList.add('was-validated');
                return;
            }

            // Prepare form data
            const formData = new FormData(editPlanForm);

            try {
                const response = await fetch('../../processes/admin-processes/process_edit_meal_plan.php', {
                    method: 'POST',
                    body: formData,
                });

                const data = await response.json();

                if (data.status === 'success') {
                    showToast(data.message, true);
                    setTimeout(() => {
                        window.location.href = "manage_meal_plans.php";
                    }, 1000);
                } else {
                    showToast(data.message, false);
                }

            } catch (error) {
                console.error('Error:', error);
                showToast('An error occurred while editing the meal plan.', false);
            }
        });
    }

    
    // check if passwords match
    const confirmPassword = document.getElementById("#confirm_password");
    if (confirmPassword) {
        confirmPassword.addEventListener("input", function() {
            const password = document.getElementById("#password");
            const passwordFeedback = document.querySelector("#confirm_password .invalid-feedback");
    
            if (password.value !== confirmPassword.value) {
                passwordFeedback.textContent = "Passwords do not match.";
                this.classList.add('was-validated');
            } else {
                passwordFeedback.textContent = "";
            }
        });
    }


    // Handle new admin/staff user creation form submission
    const createUserForm = document.getElementById("createUserForm");
    if (createUserForm) { 
        createUserForm.addEventListener("submit", async function(e) {
            e.preventDefault();

            // ensure passwords match
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirm_password").value;
            if (password !== confirmPassword) {
                //e.stopPropagation();
                document.querySelector(".confirm_password .invalid-feedback").textContent = "Passwords do not match.";
                document.getElementById("confirm_password").setCustomValidity("Passwords do not match.");

                //showToast('Passwords do not match.', false);
                //return;
            }else {
                document.getElementById("confirm_password").setCustomValidity("");
            }

            // validate form inputs
            if (!this.checkValidity()) {
                e.stopPropagation();
                this.classList.add('was-validated');
                return;
            }

            // Prepare form data
            const formData = new FormData(createUserForm);

            try {
                const response = await fetch('../../processes/admin-processes/process_create_user.php', {
                    method: 'POST',
                    body: formData,
                });

                const data = await response.json();

                if (data.status === 'success') {
                    createUserForm.reset();
                    showToast(data.message, true);

                } else {
                    showToast(data.message, false);
                }

            } catch (error) {
                console.error('Error:', error);
                showToast('An error occurred while creating the user.', false);
            }
        });
    }

    const editUserForm = document.getElementById("editUserForm");
    if (editUserForm) {
        editUserForm.addEventListener("submit", async function(e) {
            e.preventDefault();

            // Only validate password fields when the admin wants to change it.
            const newPassword = document.getElementById("new_password").value;
            const confirmPassword = document.getElementById("confirm_new_password").value;
            if (newPassword || confirmPassword) {
                if (newPassword !== confirmPassword) {
                    document.getElementById("confirm_new_password").setCustomValidity("Passwords do not match.");
                } else {
                    document.getElementById("confirm_new_password").setCustomValidity("");
                }
            } else {
                document.getElementById("confirm_new_password").setCustomValidity("");
            }

            if (!this.checkValidity()) {
                e.stopPropagation();
                this.classList.add("was-validated");
                return;
            }

            const formData = new FormData(editUserForm);

            try {
                const response = await fetch("../../processes/admin-processes/process_edit_user.php", {
                    method: "POST",
                    body: formData,
                });

                const data = await response.json();

                if (data.status === "success") {
                    showToast(data.message, true);
                    setTimeout(() => {
                        window.location.href = "manage_users.php";
                    }, 800);
                } else {
                    showToast(data.message, false);
                }
            } catch (error) {
                console.error("Error:", error);
                showToast("An error occurred while updating the user.", false);
            }
        });
    }
});
