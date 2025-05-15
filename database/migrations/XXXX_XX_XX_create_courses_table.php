// ... existing code ...
public function up(): void
{
    Schema::create('courses', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('description');
        $table->string('image')->nullable();
        $table->string('video_url')->nullable(); // URL del video de YouTube
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
}
// ... existing code ...