<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            if (! Schema::hasColumn('companies', 'slug')) {
                $table->string('slug')->nullable()->unique()->after('display_name');
            }
            if (! Schema::hasColumn('companies', 'is_profile_complete')) {
                $table->boolean('is_profile_complete')->default(false)->after('status');
            }
        });

        foreach (DB::table('companies')->whereNull('slug')->get() as $c) {
            $base = Str::slug(($c->display_name ?: $c->legal_name).'-'.Str::substr($c->id, 0, 6));
            $slug = $base;
            $i = 1;
            while (DB::table('companies')->where('slug', $slug)->where('id', '!=', $c->id)->exists()) {
                $slug = $base.'-'.$i++;
            }
            DB::table('companies')->where('id', $c->id)->update(['slug' => $slug]);
        }
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['slug', 'is_profile_complete']);
        });
    }
};
