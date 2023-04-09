import toastr from "toastr"
import "toastr/build/toastr.min.css"

export function getToastr(){
    toastr.options.closeButton = true

    return toastr
}