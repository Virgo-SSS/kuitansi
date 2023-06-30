<?php 

namespace App\Trait;

trait ToastTrait
{
    public function toastSuccess(string $message): void
    {
        $this->dispatchBrowserEvent('toast:success', ['message' => $message]);
    }

    public function toastError(string $message): void
    {
        $this->dispatchBrowserEvent('toast:error', ['message' => $message]);
    }

    public function toastInfo(string $message): void
    {
        $this->dispatchBrowserEvent('toast:info', ['message' => $message]);
    }

    public function toastWarning(string $message): void
    {
        $this->dispatchBrowserEvent('toast:warning', ['message' => $message]);
    }
}


?>