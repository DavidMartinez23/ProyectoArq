// ... existing code ...
protected function authenticated(Request $request, $user)
{
    return redirect()->route('welcome')->with([
        'message' => '¡Bienvenido a mi página web!',
        'user' => $user->name
    ]);
}
// ... existing code ...