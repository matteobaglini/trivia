xcodebuild -scheme trivia build CONFIGURATION_BUILD_DIR=build

for((seed=0;seed<10;seed++)); do
    echo Using seed:$seed
    build/trivia $seed 2>&1 | cut -d "]" -f 2
done > reference.txt
