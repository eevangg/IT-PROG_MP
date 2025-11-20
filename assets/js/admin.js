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
 

   //  Inline status edit: enter edit mode
    document.addEventListener("click", (e) => {
        if (e.target.closest(".editStatusBtn")) {
        const id = e.target.closest(".editStatusBtn").dataset.id;
        document.getElementById(`statusDisplay-${id}`).classList.add("d-none");
        document.getElementById(`statusEdit-${id}`).classList.remove("d-none");
        }
    });
    
    //  Inline status edit: cancel
    document.addEventListener("click", (e) => {
        if (e.target.closest(".cancelStatusBtn")) {
        const id = e.target.closest(".cancelStatusBtn").dataset.id;
        document.getElementById(`statusEdit-${id}`).classList.add("d-none");
        document.getElementById(`statusDisplay-${id}`).classList.remove("d-none");
        }
    });
  
});